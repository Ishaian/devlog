<?php
/**
 * Created by PhpStorm.
 * User: lilian
 * Date: 29/10/18
 * Time: 14:45
 */

namespace Controller;

use Model\User;
use Model\UserManager;

class ConnexionController extends AbstractController
{
    public function signin()
    {
        $errors = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->checkData($_POST);
            $password = sha1($_POST['password']);
            if (empty($errors)) {
                $connexionManager = new UserManager($this->getPdo());
                $connexion = new User();
                $connexion->setLastname($_POST['lastname']);
                $connexion->setFirstname($_POST['firstname']);
                $connexion->setEmail($_POST['email']);
                $connexion->setPassword($password);
                $connexion->setPseudo($_POST['pseudo']);
                $connexionManager->insertUser($connexion);
                header('Location:/');
            }
        }
        return $this->twig->render('signin.html.twig', ['errors' => $errors, 'post' => $_POST]);
    }
    public function connexion()
    {
        $password = $_POST['password'];
        $password = sha1($password);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $connexionManager = new UserManager($this->getPdo());
            $user = $connexionManager->connectUser($_POST['email'], ($password));
            if (false === $user) {
                header('Location:/?error=' . urlencode('Mauvais identifiant/mot de passe!'));
            } else {
                $_SESSION['user'] = $user;
                header('Location:/');
            }
        }
        return $this->twig->render('home.html.twig', ['errors' => $errors, 'post' => $_POST, 'session' => $_SESSION]);
    }
    public function checkData($data)
    {
        $errors = [];
        // Partie obligation de remplir + correction PHP
        if (empty($data['lastname'])) {
            $errors['lastname'] = "Veuillez renseigner votre Nom";
        } else {
            $lastname = $this->cleanInput($data['lastname']);
            if (!preg_match('/^[a-zA-Z ]*$/', $lastname)) {
                $errors['lastname'] = "Seuls les lettres et espaces sont tolérés";
            }
        }
        if (empty($data['firstname'])) {
            $errors['firstname'] = "Veuillez renseigner votre Prenom";
        }
        if (empty($data['email'])) {
            $errors['email'] = "Veuillez renseigner votre Email ";
        }
        if (empty($data['password'])) {
            $errors['password'] = "Veuillez choisir un Mot de Passe";
        }
        if ($data['password'] != $data['password_confirm']) {
            $errors['password'] = "Les deux mots de passe doivent être identiques";
        }
        if (empty($data['pseudo'])) {
            $errors['pseudo'] = "Veuillez renseigner votre Pseudo";
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
    public function logout()
    {
        session_destroy();
        header('Location:/');
    }
}
