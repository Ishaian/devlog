<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 20/10/18
 * Time: 10:59
 */

namespace Controller;

use Model\Announce;
use Model\AdminManager;

class AdminController extends AbstractController
{
    public function indexAdmin()
    {
        $addFormManager = new AdminManager($this->getPdo());
        $announces = $addFormManager->selectAll();
        return $this->twig->render('Admin/admin.html.twig', ['announces' => $announces]);// TODO changer chemin
    }
    public function editAdmin(int $id): string
    {
        $addFormManager = new AdminManager($this->getPdo());
        $announce = $addFormManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $announce->setTitle($_POST['title']);
            $announce->setContent($_POST['content']);
            $announce->setPrice($_POST['price']);
            $announce->setCapacity($_POST['capacity']);
            $announce->setCity($_POST['city']);
            $addFormManager->updateAdmin($announce);
            header('Location:/admin');
        }


        return $this->twig->render('Admin/edit.html.twig', ['announce' => $announce]);
    }

    public function add()
    {
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            if (empty($errors)) {
                $announceManager = new AdminManager($this->getPdo());
                $announce = new Announce();
                $announce->setTitle($_POST['title']);
                $announce->setContent($_POST['content']);
                $announce->setPrice($_POST['price']);
                $announce->setCapacity($_POST['capacity']);
                $announce->setCity($_POST['city']);
                $id = $announceManager->insert($announce);
                if (false !== $id) {
                    try {
                        $uploaded = FileHandler::upload($_FILES['fichier']);
                        $announce->setId($id);
                        $announce->setImg($uploaded[0]);//TODO : setImage propertie of announce
                        $announceManager->updateImg($announce);// TODO : Update announce object
                    } catch (\Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                    header('Location:/admin/' . $id);
                }
            }
        }
        return $this->twig->render('Admin/add.html.twig', ['errors' => $errors, 'post' => $_POST]);
    }
    public function deleteAdmin(int $id)
    {
        $addFormManager = new AdminManager($this->getPdo());
        $addFormManager->deleteAdmin($id);
        header('Location:/admin');
    }
}
