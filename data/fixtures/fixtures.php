<?php
/**
 * Created by Studio Slepice
 * User: Misteryyy
 * Date: 4.4.2012
 * Time: 
 */

$newQuote = new \App\Entity\Quote();
$newQuote->setWording("Don't let steal your present.");
$newQuote->setAuthor("Cherralea Morgen");
$em->persist($newQuote);
$em->flush();

$newQuote = new \App\Entity\Quote();
$newQuote->setWording("Koukni se doprava,  než přejdeš doleva.");
$newQuote->setAuthor("Josef Kortan");
$em->persist($newQuote);
$em->flush();