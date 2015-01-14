<?php


namespace Mabes\Controllers;


use Mabes\Core\Exception\InvalidCustomException;
use Respect\Validation\Exceptions\AbstractNestedException;
use Respect\Validation\Validator as v;

class RebatesController extends BaseController
{
    public function getRebates()
    {
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_rebates.twig');
    }

    public function postRebates()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new InvalidCustomException("Captcha yang anda masukan salah");
            }

            $member = $this->app->em->find("Mabes\\Entity\\Member", $this->app->request->post("login"));

            v::object()->assert($member);

            $date_range = [];
            if ($this->app->request->post("periode") == 1) {
                $date_range["start"] = strtotime("last Monday");
                $date_range["end"] = strtotime("next Sunday");
            } else {
                $last_week = strtotime("-1 week");
                $date_range["start"] = strtotime("last Monday", $last_week);
                $date_range["end"] = strtotime("next Sunday", $last_week);
            }

            $dql = "SELECT SUM(r.profit) AS Rebate FROM Mabes\Entity\Rebates r " .
                "WHERE r.login = ?1 AND r.open_time >= ?2 AND r.open_time <= ?3";
            $rebate = $this->app->em->createQuery($dql)
                ->setParameter(1, $this->app->request->post("login"))
                ->setParameter(2, $date_range["start"])
                ->setParameter(3, $date_range["end"])
                ->getSingleScalarResult();

            $rebate = (isset($rebate)) ? $rebate : 0;

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Success",
                    "successMessage" => "Rebate anda : {$rebate}"
                ]
            );
        } catch (AbstractNestedException $e) {
            $errors = $e->findMessages([
                    "object" => "Nomor login tidak dapat ditemukan didalam database",
                ]);
            $this->validationMessage($errors);
        } catch (InvalidCustomException $e) {
            $this->validationMessage([
                    "custom" => $e->getMessage()
                ]);
        }

        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_rebates.twig');
    }
}

// EOF
