<?php
class PDF extends FPDF
{
    //Current column
    var $col=0;
    //Ordinate of column start
    var $y0;

    //$cod = $_GET["cod"];

    var $cod;
    var $user;
    var $dados;

    function select()
    {
        $obj    =   new models_T0095()  ;
        
        $conn   =   'ora'               ;
        $objORA =   new models_T0095($conn)  ;
        
        $this->codigoAuditoria      =   $_GET['codigoAuditoria'];
               
        $dados = $obj->retornaRupturas($this->codigoAuditoria);
        
        //Retorna Dados
        return $dados;
    
    }
    
    function cabecalhoDados()
    {
        $this->AddPage();        
        
        $this->Ln(3);

        //FORNECEDOR NOME E COD RMS
        $this->SetFont('arial','B',10);
        $this->Cell(20,5,utf8_decode("Cód. RMS")        ,"TLRB",0,"L");
        $this->Cell(27,5,utf8_decode("Ean")             ,"TLRB",0,"L");
        $this->Cell(81,5,utf8_decode("Descrição")       ,"TLRB",0,"L");
        $this->Cell(20,5,utf8_decode("Preço RMS")       ,"TLRB",0,"L");
        $this->Cell(28,5,utf8_decode("Estoque")         ,"TLRB",0,"L");
        $this->Cell(14,5,utf8_decode("Oferta")          ,"TLRB",1,"L");
    }

    function Header()
    {
        //Page header
        global $title;

        // Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
        $this->Image('template/img/logo_davo.jpg',10,5,20);

        // Arial Negrito 30
        $this->SetFont('Arial','B',15);

        //Move to the right
        $this->Cell(30);

        //Title
        $this->Cell(120, 15, utf8_decode("AUDITORIA N° ".$this->codigoAuditoria), 0, 1, "L");
        
        
        $this->SetFont('Arial','B',20);
        $this->Cell(30);
        $this->Cell(120, 0, utf8_decode("RELATÓRIO DE RUPTURAS "), 0, 1, "L");
        
        //Line
        $this->Line(10, 32, 200, 32);
        //Line break
        $this->Ln(8);
    }

    function Footer()
    {
        //DADOS
        $this->Line(10, 275, 200, 275);
        //Captura Login para inserção
        $this->Ln(225);
        
        $this->SetXY(13, 270);
        $this->Cell(185, 15, utf8_decode("Página ".$this->page), 0, 0, "R");

    }

    function SetCol($col)
    {
        //Set position at a given column
        $this->col=$col;
        $x=10+$col*65;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        //Method accepting or not automatic page break
        if($this->col<2)
        {
            //Go to next column
            $this->SetCol($this->col+1);
            //Set ordinate to top
            $this->SetY($this->y0);
            //Keep on page
            return false;
        }
        else
        {
            //Go back to first column
            $this->SetCol(0);
            //Page break
            return true;
        }
    }

    function ChapterTitle()
    {

    }

    function ChapterBody()
    {
        $conn   =   'ora';
        $obj    =   new models_T0095($conn);
        
        $dados      =   $this->select();
                    
        $this->cabecalhoDados();

        $i  =   0;
        foreach($dados as $campos=>$valores)
        {       
            $i++;
            
            $this->Cell(20,5, $valores['CodigoRMS']                             ,"BRL",0,"L");
            $this->Cell(27,5, $valores['Ean']                                   ,"BLR",0,"L");
            $this->Cell(81,5, utf8_decode($valores['Descricao'])                ,"BLR",0,"L");
            $this->Cell(20,5, money_format('%.2n', $valores['PrecoRMS'])        ,"BLR",0,"L");
            $this->Cell(28,5, $valores['Estoque']                               ,"BLR",0,"L");
            $this->Cell(14,5,utf8_decode($valores['Oferta'])                    ,"TLRB",1,"L");	
                        
            if(($i%46)==0)
            {
                $this->cabecalhoDados();
            }

        }
    }

    function PrintChapter()
    {
        //Add chapter
        $this->ChapterBody();

    }
}

$pdf      = new PDF();
$pdf->SetTitle(utf8_decode("[Auditoria Preço] - Relatório de Rupturas"));
$pdf->PrintChapter(1,'Auditoria de Preço','');
$pdf->Output();

?>