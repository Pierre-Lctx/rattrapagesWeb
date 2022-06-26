<?php

    namespace App\controllers;

use App\core\Form;
use App\models\UserModel;

    class UserController extends Controller
    {

        //Cette méthode nous permet de générer notre formulaire de connexion
        public function login()
        {
            //Nous vérifions si le formulaire est complet
            if (Form::validate($_POST, ['EMAIL', 'PASSWORD']))
            {
                //Dans ce cas le formulaire est complet
                //Nous allons chercher dans la base de données les informations propre à l'utilisateur avec les données acquises

                $userModel = new UserModel();
                $userData = $userModel->findOneByEmail(strip_tags($_POST['EMAIL']));

                //Dans le cas où l'utilisateur n'existe pas
                if (!$userData)
                {
                    //Nous envoyons un message de session
                    $_SESSION['error'] = "Les données rentrées sont incorrect.";

                    //Nous redirigeons l'utilisateur vers la page de login
                    header('Location: /user/login');
                    exit;
                }

                //L'utilisateur existe
                $user = $userModel->hydrate($userData);
                
                //Nous allons vérifier si le mot de passe est correct
                if (password_verify($_POST['PASSWORD'], $user->getPASSWORD()))
                {
                    //Le mot de passe est bon
                    //Nous créons la session grâce à la méthode que nous avons dans le userController.php
                    $user->creerSession();
                    header('Location: /company');
                    var_dump($_SESSION);
                    exit;
                }
                else
                {
                    //Le mot de passe n'est pas bon
                    //Nous envoyons un message de session
                    $_SESSION['error'] = "L'adresse mail ou le mot de passe sont incorrects.";

                    //Nous redirigeons l'utilisateur vers la page de login
                    header('Location: /user/login');
                    exit;
                }
            }
            $form = new Form;

            //Construction du formulaire
            $form->debutForm('post','/company')
            ->ajoutLabelFor('EMAIL', 'E-mail : ')
            ->ajoutBr()
            ->ajoutInput("email", "EMAIL", ['id' => 'EMAIL','class' => 'form-control'])
            ->ajoutBr()
            ->ajoutBr()
            ->ajoutLabelFor('PASSWORD', 'Password : ')
            ->ajoutBr()
            ->ajoutInput("password", "PASSWORD", ['id' => 'PASSWORD','class' => 'form-control'])
            ->ajoutBr()
            ->ajoutBr()
            ->ajoutBouton("Connexion",['class' => 'btn btn-primary','type' => 'submit'])
            ->finForm();

            $this->render('login/index', ['loginForm' => $form->create()]);
        }

        //Cette méthode nous permet de générer notre formulaire d'insciption
        public function register()
        {
            //Nous vérifions si le formulaire est valide
            if(Form::validate($_POST, ['EMAIL', 'PASSWORD']))
            {
                //Le formulaire est valide
                //Nous allons nettoyer l'adresse mail pour limiter les injections sql et les failles xss (lorsque nous avons des balises dans un champ)

                $email = strip_tags($_POST['EMAIL']);

                //Nous allons chiffrer le mot de passe
                $password = password_hash($_POST['PASSWORD'], PASSWORD_ARGON2I);

                //Nous hydratons l'utilisateur
                $user = new UserModel();

                $user->setEMAIL($email)->setPASSWORD($password);

                //Nous stockons l'utilisateur en base de données
                $user->create();

            }

            $form = new Form;

            $form->debutForm('post','/company')
                ->ajoutLabelFor('EMAIL','E-mail :')
                ->ajoutBr()
                ->ajoutInput('email','EMAIL',['id' => 'EMAIL', 'class' => 'form-control'])
                ->ajoutBr()
                ->ajoutBr()
                ->ajoutLabelFor('PASSWORD', 'Password : ')
                ->ajoutBr()
                ->ajoutInput('password', 'PASSWORD', ['id' => 'PASSWORD', 'class' => 'form-control'])
                ->ajoutBr()
                ->ajoutBr()
                ->ajoutBouton('Inscription',['class' => 'btn btn-primary', 'type' => 'submit'])
                ->finForm();

            $this->render('login/register', ['registerForm' => $form->create()]);
        }

        //Cette méthode permet de se déconnecter l'utilisateur
        public function logout()
        {
            //Nous retirons 'user' des données de la session
            unset($_SESSION['user']);
            header('Location: /');
            exit;
        }

    }

?>