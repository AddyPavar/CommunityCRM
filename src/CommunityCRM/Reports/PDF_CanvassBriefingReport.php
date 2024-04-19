<?php

namespace CommunityCRM\Reports;

class PdfCanvassBriefingReport extends CommunityInfoReport
{
    // Constructor
    public function __construct()
    {
        parent::__construct('P', 'mm', $this->paperFormat);

        $this->SetFont('Times', '', 10);
        $this->SetMargins(0, 0);
        $this->SetAutoPageBreak(false);
        $this->addPage();
    }
}
