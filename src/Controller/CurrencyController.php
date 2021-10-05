<?php

namespace App\Controller;

use App\Entity\CurrencyCodes;
use App\Entity\IsoCodes;
use App\Form\Type\CurrencyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Currency;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CurrencyController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $cCodes = $this->getCurrencyCodes();
        // creates a task object and initializes some data for this example
        $currency = new Currency();
        $form = $this->createForm(CurrencyType::class, $currency, array('choices' => $cCodes));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $data = array();
            $data['srcCurrency'] = $task->getSrcCurrency();
            $data['destCurrency']= $task->getDestCurrency();
            $data['amount'] = $task->getAmount();

            try {
                $currencyRates = $this->getConvertCurrency(array($data['destCurrency'] => $data['destCurrency']));
                $data = array_merge($currencyRates, $data);
                $total = $currencyRates['rate'] * $data['amount'];

                // API - so do post to enter inthe db
                $currency->setConversionRate($currencyRates['rate']);
                $currency->setTotal($total);
                $currency->setDateTime($currencyRates['time']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($currency);
                $em->flush();

                return $this->renderForm('currency/total.html.twig', [
                    'amount' => $data['amount'] . " " . $data['srcCurrency'],
                    'total' => $total . " ". $data['destCurrency'],
                    'date' => $currencyRates['time'],
                    'rate' => $currencyRates['rate'],
                    'srcCurrency' => $data['srcCurrency'],
                    'destCurrency' => $data['destCurrency']
                ]);
                //update the db
            } catch (\Exception $e) {
                echo $e->getMessage();
            } catch (TransportExceptionInterface $e) {
                echo $e->getMessage();
            }
        }

        return $this->renderForm('currency/conversion.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @throws \Exception
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getConvertCurrency($currencies = array())
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'
        );
        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'text/xml'
        $content = $response->getContent();
        if (empty($content)) {
            throw new \Exception('Can not load currency rates from the European Central Bank website');
        }

        $XML = new \SimpleXMLElement($content);

        $currencies['time'] = $XML->Cube->Cube->attributes()['time'];
        foreach ($XML->Cube->Cube->Cube as $rate) {

            if (array_key_exists((string)$rate['currency'], $currencies)) {
                if(isset($rate['rate'])) {
                    $currencies['rate'] = (float)$rate['rate'];
                } else {
                    $currencies['rate'] = 1;
                }
            }
        }
        return $currencies;
    }

    /**
     * @return array
     */
    public function getCurrencyCodes(): array
    {
        $repository = $this->getDoctrine()->getRepository(CurrencyCodes::class);
        $currencyCodes = $repository->findAll();
        $cCodes = array();
        if(empty($currencyCodes)){
            throw new NotFoundHttpException();
        }
        foreach($currencyCodes as $key  => $codes) {
            $cCodes[] = $codes->getCode();
        }
        return $cCodes;

    }


    public function createCurrency(){

    }


}
