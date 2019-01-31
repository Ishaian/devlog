<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;

use Model\Announce;
use Model\AnnounceManager;
use Model\UserManager;
use Services\FileHandler;

/**
 * Class ItemController
 *
 */
class AnnounceController extends AbstractController
{
    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $addFormManager = new AnnounceManager($this->getPdo());
        $announces = $addFormManager->selectAll();
        return $this->twig->render('Annonce/announce.html.twig', ['announces' => $announces]);// TODO changer chemin
    }

    /**
     * Display item informations specified by $id
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show(int $id)
    {
        $addFormManager = new AnnounceManager($this->getPdo());
        $announce = $addFormManager->selectOneById($id);
        return $this->twig->render('Annonce/show.html.twig', ['announce' => $announce]);// TODO changer chemin
    }

    public function showAnnounce(int $id)
    {
        $addFormManager = new AnnounceManager($this->getPdo());
        $announce = $addFormManager->selectOneById($id);
        $userManager = new UserManager($this->getPdo());
        $user = $userManager->selectOneById($announce->user_announce);
        return $this->twig->render('Annonce/showAnnounce.html.twig', ['announce' => $announce, 'owner' =>$user]);// TODO changer chemin
    }

    /**
     * Display item edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function edit(int $id): string
    {
        $errors = [];
        $addFormManager = new AnnounceManager($this->getPdo());
        $announce = $addFormManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $announce->setTitle($_POST['title']);
            $announce->setContent($_POST['content']);
            $announce->setPrice($_POST['price']);
            $announce->setCapacity($_POST['capacity']);
            $announce->setCity($_POST['city']);
            $announce->setGood($_POST['good']);
            $announce->setActivity($_POST['activity']);
            $addFormManager->update($announce);
            try {
                $uploaded = FileHandler::upload($_FILES['fichier']);
                $announce->setId($id);
                $announce->setImg($uploaded[0]);
                $addFormManager->updateImg($announce);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
          
            if (empty($errors)) {
                header('Location:/announce/' . $id);
            }
        }
        return $this->twig->render('Annonce/edit.html.twig', ['announce' => $announce]);
    }

        /**
         * Display item creation page
         *
         * @return string
         * @throws \Twig_Error_Loader
         * @throws \Twig_Error_Runtime
         * @throws \Twig_Error_Syntax
         */

    public function quickSearch()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!empty($_GET['city'])) {
                $city = $_GET['city'];
                $searchManager = new AnnounceManager($this->getPdo());
                $announces = $searchManager->selectByCity($city);
                return $this->twig->render('Annonce/quickAnnounce.html.twig', ['announces' => $announces]);
            }
        }
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $searchManager = new AnnounceManager($this->getPdo());
            $announces = $searchManager->selectBySearch($_GET);
        }
        return $this->twig->render('Annonce/searchAnnounce.html.twig', ['announces' => $announces]);
    }


    public function add()
    {
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $announceManager = new AnnounceManager($this->getPdo());
                $announce = new Announce();
                $announce->setTitle($_POST['title']);
                $announce->setContent($_POST['content']);
                $announce->setPrice($_POST['price']);
                $announce->setCapacity($_POST['capacity']);
                $announce->setCity($_POST['city']);
                $announce->setGood($_POST['good']);
                $announce->setActivity($_POST['activity']);
                $id = $announceManager->insert($announce);
                if (false !== $id) {
                    try {
                        $uploaded = FileHandler::upload($_FILES['fichier']);
                        $announce->setId($id);
                        $announce->setImg($uploaded[0]);
                        $announceManager->updateImg($announce);
                    } catch (\Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                    header('Location:/announce/' . $id);
                }
            }
        }
        return $this->twig->render('Annonce/add.html.twig', ['errors' => $errors, 'post' => $_POST]);
    }

        /**
          * Handle item deletion
         *
         * @param int $id
         */

    public function delete(int $id)
    {
        $addFormManager = new AnnounceManager($this->getPdo());
        $addFormManager->delete($id);
        header('Location:/announce');
    }

    public function checkData($data)
    {
        $errors = [];
        // Partie obligation de remplir + correction PHP
        if (empty($data['title'])) {
            $errors['title'] = "Veuillez écrire un titre";
        } else {
            $title = $this->cleanInput($data['title']);
            if (!preg_match('/^[a-zA-Z ]*$/', $title)) {
                $errors['title'] = "Seuls les lettres et espaces sont tolérés";
            }
        }
        if (empty($data['content'])) {
            $errors['content'] = "Veuillez écrire une description";
        }
        if (empty($data['price'])) {
            $errors['price'] = "Veuillez définir un prix en euro ";
        } else {
            $price = $this->cleanInput($data['price']);
            if (!preg_match('\d+(\.\d{2})?', $price)) {
                //$errors['price'] = "Seuls les nombres sont autorisés";
            }
        }
        if (empty($data['capacity'])) {
            $errors['capacity'] = "Veuillez choisir le nombre de personne";
        } else {
            $price = $this->cleanInput($data['price']);
            if (!preg_match('/\d{1,3}/', $price)) {
                $errors['capacity'] = "Seuls les chiffres et nombres sont autorisés";
            }
        }

        return $errors;
    }

    private function cleanInput($variable)
    {
        $variable = trim($variable);
        $variable = stripslashes($variable);
        $variable = htmlspecialchars($variable);
        return $variable;
    }
}
