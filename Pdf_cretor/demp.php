<?php
/**
 * Created by PhpStorm.
 * User: Jason·wealson
 * Date: 2017/6/28
 * Time: 13:13
 * TcPDF类生成pdf
 */
require_once 'tcpdf/tcpdf.php';
$pdf = new TCPDF('p','mm','A4',true,'UTF-8',false);

//设置文档信息
$pdf->setCreator('Hello world');
$pdf->setAuthor('jason-wealson');
$pdf->setTitle('Hello for fun');
$pdf->setSubject('TCPDF test');
$pdf->setKeywords('TCPDF PHP');
$html = "<h1>hello world</h1><h2>你好，欢迎来到编程世界</h2>";
//设置页眉和页脚信息
$pdf->SetHeaderData('',30,'hello world','just for test tcpdf',array(0,64,255),array(0,64,168));
$pdf->setFooterData(array(0,64,0),array(0,64,128));

//设置页面和页脚字体
$pdf->setHeaderFont(array('stsongstdlight','',10));
$pdf->setFooterFont(array('helvetica','',8));

//设置默认等宽字体
$pdf->SetDefaultMonospacedFont('courier');

//设置间距
$pdf->SetMargins(15,27,15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

//设置分页
$pdf->SetAutoPageBreak(true,25);

$pdf->setImageScale(1.25);
$pdf->setFontSubsetting(true);

//设置字体
$pdf->SetFont('stsongstdlight','',14);
$pdf->AddPage();
$str =  html_entity_decode($html);
$pdf->Write(0,$str,'',0,'L',true,0,false,false,0);

//输出pdf
$pdf->Output('tcp.pdf','I');