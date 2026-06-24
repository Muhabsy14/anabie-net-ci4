<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanPdfService
{
    public function streamFromHtml(string $html, string $filename): void
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}
