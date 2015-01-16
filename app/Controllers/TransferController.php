<?php
/**
 * Created by PhpStorm.
 * User: awalin
 * Date: 15/01/15
 * Time: 10:30
 */

namespace Mabes\Controllers;

use Mabes\Entity\Transfer;
use Mabes\Core\Exception\InvalidCustomException;
use Respect\Validation\Exceptions\AbstractNestedException;

class TransferController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

    }

    public function getTransfer()
    {
        $this->app->render('Pages/_transferBalance.twig');
    }

    public function postTransfer()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new InvalidCustomException("Captcha yang anda masukan salah");
            }

            $member_from = $this->app->em->find("Mabes\\Entity\\Member", $this->app->request->post("login_from"));
            $member_to = $this->app->em->find("Mabes\\Entity\\Member", $this->app->request->post("login_to"));

            v::object()->assert($member_from);
            v::object()->assert($member_to);

            $transfer = new Transfer();
            $transfer->massAssignment($this->app->request->post());
            $transfer->setFromLogin($member_from);
            $transfer->setToLogin($member_to);

            $this->app->em->persist($transfer);
            $this->app->em->flush();

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Success",
                    "successMessage" => "Transfer Request anda sudah kami terima"
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
                    "startsWith" => "Nomor telepon harus berawalan dengan +",
                    'uploaded' => "file upload gagal"
                ]
            );

            $this->validationMessage($errors);
        } catch (InvalidCustomException $e) {
            $this->validationMessage([
                "custom" => $e->getMessage()
            ]);
        }
        $this->app->render('Pages/_transferBalance.twig');
    }
}
