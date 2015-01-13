<?php


namespace Mabes\Controllers;

use Mabes\Core\Exception\InvalidCaptchaException;
use Mabes\Entity\Withdrawal;
use Respect\Validation\Exceptions\AbstractNestedException;
use Respect\Validation\Validator as v;

class WithdrawalController extends BaseController
{
    public function getWithdrawal()
    {
        if ($this->app->request->isGet()) {

            $this->app->view()->appendData(
                [
                    "captcha" => $this->buildCaptcha()
                ]
            );

            $this->app->render('Pages/_withdrawal.twig');
        }
    }

    public function postWithdrawal()
    {
        try {

            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new InvalidCaptchaException("Captcha yang anda masukan salah");
            }

            $member = $this->app->em->find("Mabes\\Entity\\Member", $this->app->request->post("login"));

            v::object()->assert($member);

            $withdrawal = new Withdrawal();
            $withdrawal->setAccountName($this->app->request->post("account_name"));
            $withdrawal->setPhone($this->app->request->post("phone"));
            $withdrawal->setPhonePassword($this->app->request->post("phone_password"));
            $withdrawal->setEmail($this->app->request->post("email"));
            $withdrawal->setClient($member);
            $withdrawal->setAmount($this->app->request->post("amount"));
            $withdrawal->setBankAccount($this->app->request->post("bank_account"));
            $withdrawal->setBankName($this->app->request->post("bank_name"));
            $withdrawal->setStatus(Withdrawal::STATUS_OPEN);

            $this->app->em->persist($withdrawal);
            $this->app->em->flush();

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTtle" => "Success",
                    "successMessage" => "Withdrawal anda sudah kami terima"
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
                    "object" => "Nomor login tidak dapat ditemukan didalam database",
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
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_withdrawal.twig');
    }
}

// EOF
