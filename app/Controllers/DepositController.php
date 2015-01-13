<?php
/**
 * Created by PhpStorm.
 * User: awalin
 * Date: 13/01/15
 * Time: 17:45
 */

namespace Mabes\Controllers;

use Mabes\Core\Exception\InvalidCaptchaException;
use Mabes\Entity\Deposit;
use Respect\Validation\Exceptions\AbstractNestedException;
use Respect\Validation\Rules\Uploaded;
use Respect\Validation\Validator as v;

class DepositController extends BaseController
{
    public function getDeposit()
    {

        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha(),
                'bank' => $this->app->em->getRepository("Mabes\\Entity\\Bank")->findAll()
            ]
        );

        $this->app->render('Pages/_deposit.twig');
    }

    public function postDeposit()
    {
        try {

            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new InvalidCaptchaException("Captcha yang anda masukan salah");
            }

            $member = $this->app->em->find("Mabes\\Entity\\Member", $this->app->request->post("login"));
            $bank = $this->app->em->find("Mabes\\Entity\\Bank", $this->app->request->post('bank_to'));


//            v::uploaded()->validate()
            v::object()->assert($member);
            v::object()->assert($bank);

            $deposit = new Deposit();
            $deposit->massAssignment($this->app->request->post());
            $deposit->setClient($member);
            $deposit->setBank($bank);
            $deposit->setStatus(Deposit::STATUS_OPEN);

            $this->app->em->persist($deposit);
            $this->app->em->flush();

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Success",
                    "successMessage" => "Deposit anda sudah kami terima"
                ]
            );
        } catch (AbstractNestedException $e) {

            $errors = $e->findMessages(
                [
                    "numeric" => "{{name}} harus berisi numeric",
                    "alnum" => "{{name}} harus berisi alphanumeric",
                    "email" => "{{name}} harus berisi email yang valid",
                    "float" => "{{name}} harus bernilai desimal",
                    "notEmpty" => "Mohon diisi semua field",
                    "equals" => "{{input}} tidak cocok dengan yang ada didatabase",
                    "object" => "no login tidak dapat ditemukan didalam database",
                    "startsWith" => "Nomor telepon harus berawaln dengan +"
                ]
            );

            $this->validationMessage($errors);
        } catch (InvalidCaptchaException $e) {
            $this->validationMessage([
                "custom" => $e->getMessage()
            ]);
        }

        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha(),
                'bank' => $this->app->em->getRepository("Mabes\\Entity\\Bank")->findAll()
            ]
        );

        $this->app->render('Pages/_deposit.twig');
    }


} 