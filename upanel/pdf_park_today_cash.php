<?php   
ob_start();
 require_once ("../include/initialize.php");
 if(isset($_REQUEST['criteria']) AND isset($_REQUEST['user']) ){
    $date =date("Y-m-d H:s:i"); 
    $criteria = $_REQUEST['criteria']; 
    $user = $_REQUEST['user']; 
    
    $no =0;
    $stms_doctor = $conn->prepare(" SELECT * FROM park_out WHERE ".$criteria." AND total_paid is not null ");                     
    try {
    $stms_doctor->execute(array());
    $row_doctor = $stms_doctor->rowCount();
    if ($row_doctor > 0)
    
    {
        $sql = " SELECT* FROM tbl_user_access WHERE u_id ='$user' ";
        $query = $conn->prepare($sql);
        $query->execute();
        while($fetch = $query->fetch()){
            $place_name = $fetch['u_names'];
            $phone = $fetch['phone'];
        }
        
        $selecttotal=$conn->prepare("select sum(total_paid) as totalcash from park_out where ".$criteria." AND total_paid is not null");
        $selecttotal->execute();
        $totalCash = $selecttotal->fetch();
        
    // pdf starting Data
    
    ob_start();
    require('../fpdf16/fpdf.php');
    Header('Pragma: public');
    
    // It will be called downloaded.pdf
    //print watermark
    class PDF_Rotate
            extends FPDF {
    
        var $angle = 0;
    
        function Rotate($angle, $x = -1, $y = -1) {
            if ($x == -1)
                $x = $this->x;
            if ($y == -1)
                $y = $this->y;
            if ($this->angle != 0)
                $this->_out('Q');
            $this->angle = $angle;
            if ($angle != 0)
                {
                $angle*=M_PI / 180;
                $c = cos($angle);
                $s = sin($angle);
                $cx = $x * $this->k;
                $cy = ($this->h - $y) * $this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
                }
        }
    
        function _endpage() {
            if ($this->angle != 0)
                {
                $this->angle = 0;
                $this->_out('Q');
                }
            parent::_endpage();
        }
    
    }
    
    //inherits watermark to pdf
    class PDF
    extends PDF_Rotate {
    
    //barcode generation
        function Code39($xpos, $ypos, $code, $baseline = 0.5, $height = 5) {
            $wide = $baseline;
            $narrow = $baseline / 3;
            $ga = $narrow;
            $barChar['0'] = 'nnnwwnwnn';
            $barChar['1'] = 'wnnwnnnnw';
            $barChar['2'] = 'nnwwnnnnw';
            $barChar['3'] = 'wnwwnnnnn';
            $barChar['4'] = 'nnnwwnnnw';
            $barChar['5'] = 'wnnwwnnnn';
            $barChar['6'] = 'nnwwwnnnn';
            $barChar['7'] = 'nnnwnnwnw';
            $barChar['8'] = 'wnnwnnwnn';
            $barChar['9'] = 'nnwwnnwnn';
            $barChar['A'] = 'wnnnnwnnw';
            $barChar['B'] = 'nnwnnwnnw';
            $barChar['C'] = 'wnwnnwnnn';
            $barChar['D'] = 'nnnnwwnnw';
            $barChar['E'] = 'wnnnwwnnn';
            $barChar['F'] = 'nnwnwwnnn';
            $barChar['G'] = 'nnnnnwwnw';
            $barChar['H'] = 'wnnnnwwnn';
            $barChar['I'] = 'nnwnnwwnn';
            $barChar['J'] = 'nnnnwwwnn';
            $barChar['K'] = 'wnnnnnnww';
            $barChar['L'] = 'nnwnnnnww';
            $barChar['M'] = 'wnwnnnnwn';
            $barChar['N'] = 'nnnnwnnww';
            $barChar['O'] = 'wnnnwnnwn';
            $barChar['P'] = 'nnwnwnnwn';
            $barChar['Q'] = 'nnnnnnwww';
            $barChar['R'] = 'wnnnnnwwn';
            $barChar['S'] = 'nnwnnnwwn';
            $barChar['T'] = 'nnnnwnwwn';
            $barChar['U'] = 'wwnnnnnnw';
            $barChar['V'] = 'nwwnnnnnw';
            $barChar['W'] = 'wwwnnnnnn';
            $barChar['X'] = 'nwnnwnnnw';
            $barChar['Y'] = 'wwnnwnnnn';
            $barChar['Z'] = 'nwwnwnnnn';
            $barChar['-'] = 'nwnnnnwnw';
            $barChar['.'] = 'wwnnnnwnn';
            $barChar[' '] = 'nwwnnnwnn';
            $barChar['*'] = 'nwnnwnwnn';
            $barChar['$'] = 'nwnwnwnnn';
            $barChar['/'] = 'nwnwnnnwn';
            $barChar['+'] = 'nwnnnwnwn';
            $barChar['%'] = 'nnnwnwnwn';
            $this->SetFont('Times', '', 10);
            $this->Text($xpos, $ypos + $height + 4, $code);
            $this->SetFillColor(0);
            $code = '*' . strtoupper($code) . '*';
            for ($i = 0; $i < strlen($code); $i++) {
                $char = $code[$i];
                if (!isset($barChar[$char]))
                    {
                    $this->Error('Invalid character in barcode: ' . $char);
                    }
                $seq = $barChar[$char];
                for ($bar = 0; $bar < 9; $bar++) {
                    if ($seq[$bar] == 'n')
                        {
                        $lineWidth = $narrow;
                        }
                    else
                        {
                        $lineWidth = $wide;
                        }
                    if ($bar % 2 == 0)
                        {
                        $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
                        }
                    $xpos += $lineWidth;
                }
                $xpos += $gap;
            }
        }
    
    //Page header
        function Header()
    {
        
       $this->SetY(20);	//Logo
    $this->Image('../img/logo.jpg',10,10,30);
        //Arial bold 15
        $this->SetFont('Arial','B',18);
        //Move to the right
       
        $this->Cell(60);
        //Title
           $this->Cell(157,7,'PARKING TODAY CASH REPORT',0,0,'C');
    	  
     $this->SetFont('Arial','BU',13);
    
    	 //$this->Cell(-150,50,'CLASS LIST',0,0,'C');
    
        //Line break
         $this->Cell(50);
    	//Put the watermark
    	$this->SetFont('Arial','B',16);
    	$this->SetTextColor(253, 242, 242);
    
    	$this->RotatedText(120,5,' ',45);
    	$this->Ln(15);
    }
    
        function RotatedText($x, $y, $txt, $angle) {
            //Text rotated around its origin
            $this->Rotate($angle, $x, $y);
            $this->Text($x, $y, $txt);
            $this->Rotate(0);
        }
    
    //Page footer
        function Footer()
    {
    	$this->SetTextColor(0,0,0);
        $this->SetY(-20);
        $this->SetFont('Arial','',10);
    	//Position at 1.5 cm from bottom
    	 $this->Cell(300,10,'~  C Parking  ~',0,0,'C');
    	
    }
    
        var $B;
        var $I;
        var $U;
        var $HREF;
    
        function PDF($orientation = 'L', $unit = 'mm', $format = 'A4') {
            //Call parent constructor
            $this->FPDF($orientation, $unit, $format);
            //Initialization
            $this->B = 0;
            $this->I = 0;
            $this->U = 0;
            $this->HREF = '';
        }
    
        function WriteHTML($html) {
            //HTML parser
            $html = str_replace("\n", ' ', $html);
            $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
            foreach ($a as $i => $e) {
                if ($i % 2 == 0)
                    {
                    //Text
                    if ($this->HREF)
                        $this->PutLink($this->HREF, $e);
                    else
                        $this->Write(5, $e);
                    }
                else
                    {
                    //Tag
                    if ($e[0] == '/')
                        $this->CloseTag(strtoupper(substr($e, 1)));
                    else
                        {
                        //Extract attributes
                        $a2 = explode(' ', $e);
                        $tag = strtoupper(array_shift($a2));
                        $attr = array();
                        foreach ($a2 as $v) {
                            if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                                $attr[strtoupper($a3[1])] = $a3[2];
                        }
                        $this->OpenTag($tag, $attr);
                        }
                    }
            }
        }
    
        function OpenTag($tag, $attr) {
            //Opening tag
            if ($tag == 'B' || $tag == 'I' || $tag == 'U')
                $this->SetStyle($tag, true);
            if ($tag == 'A')
                $this->HREF = $attr['HREF'];
            if ($tag == 'BR')
                $this->Ln(5);
        }
    
        function CloseTag($tag) {
            //Closing tag
            if ($tag == 'B' || $tag == 'I' || $tag == 'U')
                $this->SetStyle($tag, false);
            if ($tag == 'A')
                $this->HREF = '';
        }
    
        function SetStyle($tag, $enable) {
            //Modify style and select corresponding font
            $this->$tag+=($enable ? 1 : -1);
            $style = '';
            foreach (array('B', 'I', 'U') as $s) {
                if ($this->$s > 0)
                    $style.=$s;
            }
            $this->SetFont('', $style);
        }
    
        function PutLink($URL, $txt) {
            //Put a hyperlink
            $this->SetTextColor(0, 0, 255);
            $this->SetStyle('U', true);
            $this->Write(5, $txt, $URL);
            $this->SetStyle('U', false);
            $this->SetTextColor(0);
        }
    
    }
    
    //Instanciation of inherited class
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 12);
    
    //$pdf->SetAuthor('http://www.reb.gov.rw');
    $pdf->SetTitle(" PARKING TODAY CASH REPORT ");
        
        $pdf->Ln();
    	$pdf->SetTextColor(0, 0, 0);
    	$pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(40,3,'',0,1,'L');
        
    	$pdf->Ln();
    	$pdf->SetTextColor(0, 0, 0);
    	$pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(40,3,$place_name,0,1,'L');
        
        $pdf->Ln();
    	$pdf->SetTextColor(0, 0, 0);
    	$pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(20,3,'Address : Kigali - Rwanda',0,1,'L');
        
        $pdf->Ln();
    	$pdf->SetTextColor(0, 0, 0);
    	$pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(40,3,'Contact : '.$phone,0,1,'L');
        
        $pdf->Ln();
    	$pdf->SetTextColor(0, 0, 0);
    	$pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(40,3,'Exported Date : '.$date,0,1,'L');
        
        
        $pdf->Ln(10);
    	$pdf->SetFont('Times', 'BU', 15);
    	$pdf->SetTextColor(0,0,0);	
    	$pdf->Cell(165, 1," Parking Today Cash Lists ", 0, 1, 'R');
    	$pdf->SetFont('Times', 'BU', 14);
    	$pdf->SetTextColor(67, 90, 180);
        $pdf->Ln(5);
        $pdf->SetTextColor(0, 0, 0);
    	
    	
    	$ii = 1;
    	//Tables header
    	$pdf->SetFont('Times', 'B', 12);
    	$pdf->SetTextColor(0, 0, 0);
    	$pdf->Cell(10, 7, '');
    	$pdf->Cell(10, 7, 'No', 1);
    	$pdf->Cell(40, 7, 'License Plate', 1);
    	$pdf->Cell(40, 7, 'Entry Time ', 1);
    	$pdf->Cell(40, 7, 'Exit Time', 1);
    	$pdf->Cell(40, 7, 'Time Used', 1);
    	$pdf->Cell(40, 7, 'Cash Paid', 1);
    	$pdf->Cell(40, 7, 'Served By', 1);
    	
    	$pdf->Ln();
    	
    	function getUsedTime($timeused) {
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, $timeused);
            return $date->format('H:i:s');
    	}
    	
        while($rows_2 = $stms_doctor->fetch(PDO::FETCH_ASSOC)) {   
            $no +=1;
            $user=$rows_2['user'];
            $code=$rows_2['card_code'];
            
            $sql3="SELECT* FROM tbl_user_access WHERE u_id ='$user'";
            $user=$conn->prepare($sql3);
            $user->execute();
            $us=$user->fetch();
            
            $select1=$conn->prepare("select * from park_in where p_in_id = '".$rows_2['p_in_id']."'");
            $select1->execute();
            $rowPin = $select1->fetch();
            $timein = getUsedTime($rowPin['entre_time']);
            
            $diff_time = strtotime($timein) - strtotime($rows_2['exit_time']);
            $timeUsed = gmdate('H:i:s', abs($diff_time));
            
            $sql2="SELECT* FROM park_card WHERE card_code ='$code'";
            $res=$conn->prepare($sql2);
            $res->execute();
            $cardtype=$res->fetch();
            
        	$pdf->SetFont('Times', '', 12);										
        	$pdf->SetTextColor(0, 0, 0);
        	//Putting data in the table
        	$pdf->Cell(10, 7, '');
        	$pdf->Cell(10, 7, $no, 1);
        	$pdf->Cell(40, 7, $rowPin['card_code'], 1);
        	$pdf->Cell(40, 7, $rowPin['entre_time'], 1);
        	$pdf->Cell(40, 7, $rows_2['exit_time'], 1);
        	$pdf->Cell(40, 7, $timeUsed, 1);
        	$pdf->Cell(40, 7, $rows_2['total_paid'], 1);
        	$pdf->Cell(40, 7, $us['username'], 1);
        					
        	$pdf->Ln();
    		
            }
        }
            
            $pdf->Ln();
        	$pdf->SetTextColor(0, 0, 0);
        	$pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(40,3,'Total Amount : '.$totalCash['totalcash'].' Frw',0,1,'L');
		
    }
        catch (PDOException $ex) {
          echo $ex->getMessage();
        }
    }
    
    	
    
    $pdf->SetFont('Times', 'B', 12);   
    $pdf->Ln(12);
    $pdf->Cell(5, 6, '');
    //$pdf->Cell(5, 5, 'REB (TMIS)', 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(5, 6, '');
    //$pdf->Cell(5, 5, 'TMIS', 0, 1, 'L');
    $pdf->Ln(12);
    $pdf->SetFont('Times', 'I', 8);
    //$pdf->Cell(0, 10, 'Downloaded on: ' . $dat, 0, 1, 'R');
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Ln(0);
    //$pdf->Cell(0, 10, '(This is computer generated document and not valid if manually altered)', 0, 1, 'C');
    $n1 = $tech_name." PARKING TODAY CASH REPORT ";
    $pdf->Output($n1 . '.pdf', 'I');
    $pdf->Output();
    
    exit;
    ob_end_flush();
    
    // end of pdf Data
 
  ?>