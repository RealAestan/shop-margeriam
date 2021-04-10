<?php

declare(strict_types=1);

namespace App\Email;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Knp\Snappy\GeneratorInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\InvoicingPlugin\Email\Emails;
use Sylius\InvoicingPlugin\Email\InvoiceEmailSenderInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Sylius\InvoicingPlugin\Filesystem\TemporaryFilesystem;
use Sylius\InvoicingPlugin\Generator\InvoicePdfFileGeneratorInterface;

final class InvoiceEmailSender implements InvoiceEmailSenderInterface
{
    /** @var SenderInterface */
    private $emailSender;

    /** @var InvoicePdfFileGeneratorInterface */
    private $invoicePdfFileGenerator;

    /** @var TemporaryFilesystem */
    private $temporaryFilesystem;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var GeneratorInterface */
    private $pdfGenerator;

    public function __construct(
        SenderInterface $emailSender,
        InvoicePdfFileGeneratorInterface $invoicePdfFileGenerator,
        LocaleContextInterface $localeContext,
        PageRepositoryInterface $pageRepository,
        GeneratorInterface $pdfGenerator
    ) {
        $this->emailSender = $emailSender;
        $this->invoicePdfFileGenerator = $invoicePdfFileGenerator;
        $this->temporaryFilesystem = new TemporaryFilesystem();
        $this->localeContext = $localeContext;
        $this->pageRepository = $pageRepository;
        $this->pdfGenerator = $pdfGenerator;
    }

    public function sendInvoiceEmail(
        InvoiceInterface $invoice,
        string $customerEmail
    ): void {
        $pdfInvoice = $this->invoicePdfFileGenerator->generate($invoice);
        $page = $this->pageRepository->findOneEnabledByCode('terms_and_conditions', $this->localeContext->getLocaleCode());
        /** @var string $filename */
        $filenameTermsAndConditions = str_replace(' ', '_', $page->getName()) . '.pdf';

        $pdfTermsAndConditions = $this->pdfGenerator->getOutputFromHtml($page->getContent());

        // Since Sylius' Mailer does not support sending attachments which aren't real files
        // we have to simulate the file being on the local filesystem, so that we save the PDF,
        // run the callable and delete it when the callable is finished.
        $this->temporaryFilesystem->executeWithFile(
            $pdfInvoice->filename(),
            $pdfInvoice->content(),
            function (string $filepath) use ($invoice, $customerEmail, $filenameTermsAndConditions, $pdfTermsAndConditions): void {
                $this->temporaryFilesystem->executeWithFile(
                    $filenameTermsAndConditions,
                    $pdfTermsAndConditions,
                    function (string $filePathTermsAndConditions) use ($invoice, $customerEmail, $filepath): void {
                        $this->emailSender->send(Emails::INVOICE_GENERATED, [$customerEmail], ['invoice' => $invoice], [$filepath, $filePathTermsAndConditions]);
                    }
                );
            }
        );
    }
}
