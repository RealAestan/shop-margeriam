<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Currency\Model\ExchangeRateInterface;
use Sylius\Component\Currency\Repository\ExchangeRateRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateExchangeRatesCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /** @var ExchangeRateRepositoryInterface */
    private $exchangeRateRepository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        ExchangeRateRepositoryInterface $exchangeRateRepository
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->exchangeRateRepository = $exchangeRateRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:exchange-rates:update')
            ->addArgument('exchangeratesUrl', InputArgument::OPTIONAL, 'URL', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml')
            ->setDescription('Update exchange rates.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getName() . ' started at ' . date('Y-m-d H:i:s'));

        $currencies = [];
        $exchangeRates = $this->exchangeRateRepository->findAll();
        foreach ($exchangeRates as $exchangeRate) {
            assert($exchangeRate instanceof ExchangeRateInterface);
            assert($exchangeRate->getSourceCurrency() !== null);
            $currencies[] = $exchangeRate->getSourceCurrency()->getCode();
        }

        $exchangeRatesUrl = $input->getArgument('exchangeratesUrl');
        assert(is_string($exchangeRatesUrl));
        $xml = file_get_contents($exchangeRatesUrl);
        $currentExchangeRates = [];
        if ($xml === false) {
            $errorMsg = 'Missing XML source';
            $io->warning($errorMsg);
            $this->logger->warning($errorMsg);
        } else {
            $parsedXML = new \SimpleXMLElement(file_get_contents($exchangeRatesUrl));
            foreach($parsedXML->Cube->Cube->children() as $rate) {
                $currentExchangeRates[(string) $rate['currency']] = ['EUR' => floatval($rate['rate'])];
            }
        }

        foreach ($exchangeRates as $exchangeRate) {
            assert($exchangeRate instanceof ExchangeRateInterface);

            assert($exchangeRate->getSourceCurrency() !== null);
            assert($exchangeRate->getTargetCurrency() !== null);
            $sourceCurrency = $exchangeRate->getSourceCurrency()->getCode();
            $targetCurrency = $exchangeRate->getTargetCurrency()->getCode();
            assert($sourceCurrency !== null);
            assert($targetCurrency !== null);

            if (!array_key_exists($sourceCurrency, $currentExchangeRates)) {
                continue;
            }
            if (!array_key_exists($targetCurrency, $currentExchangeRates[$sourceCurrency])) {
                $errorMsg = 'Convert table key ' . $sourceCurrency . ' does not contain ' . $targetCurrency;
                $io->warning($errorMsg);
                $this->logger->warning($errorMsg);

                continue;
            }
            $rate = $currentExchangeRates[$sourceCurrency][$targetCurrency];
            if ($rate === 0) {
                $errorMsg = 'Exchange Rate = 0... skip';
                $io->warning($errorMsg);
                $this->logger->warning($errorMsg);

                continue;
            }

            $exchangeRate->setRatio($rate);
            $this->entityManager->persist($exchangeRate);

            $io->title('Update ' . $sourceCurrency . ' to ' . $targetCurrency . ' with rate ' . $rate);
        }
        $this->entityManager->flush();

        $io->success(
            $this->getName() . ' at ' . date('Y-m-d H:i:s')
        );
    }
}
