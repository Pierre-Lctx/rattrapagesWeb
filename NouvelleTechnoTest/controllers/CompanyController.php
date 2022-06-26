<?php

    namespace App\controllers;

    use App\core\Form;
    use App\models\CompanyModel;

    class CompanyController extends Controller
    {

        //Cette méthode affichera une page avec toutes les entreprises de la page de données
        public function index()
        {
            //Nous allons instancier le modèle correspondant à la table entreprise de notre base de données
            $companyModel = new CompanyModel;

            //Par défaut nous mettons la page actuelle qui est dans la session
            $pageDefaut =  $_SESSION['page'];

            if(isset($_POST['anciennePage']))
            {
                $pageActuelle = $_POST['anciennePage'];
            }
            else if(isset($_POST['nouvellePage']))
            {
                $pageActuelle = $_POST['nouvellePage'];
            }
            else 
            {
                $pageActuelle = $pageDefaut;
            }


            //Nous allons chercher toutes les entreprises
            $company = $companyModel->findAllWithPagination($pageActuelle, 5);

            $firstData = ceil($pageActuelle * 5) - 5;

            $page = [
                'numberOfPage' => (int) $companyModel->getNumberOfPages(5),
                'currentPage' => $pageActuelle,
                'firstData' => $firstData,
                'totalData' => (int) $companyModel->getNumberOfData()
            ];
            
            //Nous générons la vue
            $this->render('company/index', ['company' => $company, 'page' => $page]);
        }

        //Cette méthode permet d'afficher une entreprise et toutes ses données associées
        public function lire(int $id)
        {
            if (isset($_SESSION['user']) && !empty($_SESSION['user']['ID_USER']))
            {
                //L'utilisateur est connecté

                //Nous instancions le modèle
                $companyModel = new CompanyModel;

                //Nous allons chercher une entreprise
                $company = $companyModel->find("ID_COMPANY", $id);

                //Nous envoyons à la vue
                $this->render('company/lire', ['company' => $company]);
            }
            else 
            {
                //L'utilisateur n'est pas connecté
                $_SESSION['error'] = "Une connexion est nécessaire pour accèder à la lecture d'entreprise";
                header('Location: /user/login');
                exit;
            }
            
        }

        //Cette méthode permet de modifier les données relatives à une entreprise
        public function modifier(int $id)
        {
            if (isset($_SESSION['user']) && !empty($_SESSION['user']['ID_USER']))
            {
                //L'utilisateur est connecté
                //Nous vérifions que l'annonce existe dans la base de données
                //Nous instancions notre modèle
                $companyModel = new CompanyModel;

                //Nous cherchons l'annonce avec l'id
                $company = $companyModel->find("ID_COMPANY", $id);

                //Dans le cas où l'entreprise n'existe pas nous retournons à la liste des entreprises
                if (!$company)
                {
                    http_response_code(404);
                    $_SESSION['error'] = "L'annonce recherchée n'existe pas !";
                    header('Location: /company');
                    exit;
                }

                //Nous vérifions que le formulaire soit complet
                if (Form::validate($_POST, 
                ['COMPANY_NAME', 
                'ACTIVITY_SECTOR', 
                'NUMBER_OF_STUDENTS', 
                'TOWN_NAME', 
                'NUMBER', 
                'STREET', 
                'POSTAL_CODE', 
                'COMPLEMENT', 
                'NUM_SIRET', 
                'NUM_SIREN']))
                {
                    //Si le formulaire est complet
                    //Nous nous proteger contre les failles XSS et les injections SQL
                    //Avec strip_tags, htmlentities, htmlspecialchars
                    $company_name = strip_tags($_POST['COMPANY_NAME']);
                    $activity_sector = strip_tags($_POST['ACTIVITY_SECTOR']);
                    $number_of_students = strip_tags($_POST['NUMBER_OF_STUDENTS']);
                    $town_name = strip_tags($_POST['TOWN_NAME']);
                    $number = strip_tags($_POST['NUMBER']);
                    $street = strip_tags($_POST['STREET']);
                    $postal_code = strip_tags($_POST['POSTAL_CODE']);
                    $complement = strip_tags($_POST['COMPLEMENT']);
                    $num_siret = strip_tags($_POST['NUM_SIRET']);
                    $num_siren = strip_tags($_POST['NUM_SIREN']);

                    //Nous enregistrons notre annonce
                    $companyModified = new CompanyModel;

                    //Nous hydratons

                    $companyModified->setID_COMPANY($company->ID_COMPANY)
                        ->setCOMPANY_NAME($company_name)
                        ->setACTIVITY_SECTOR($activity_sector)
                        ->setNUMBER_OF_STUDENTS($number_of_students)
                        ->setNUM_SIREN($num_siren)
                        ->setNUM_SIRET($num_siret)
                        ->setTOWN_NAME($town_name)
                        ->setNUMBER($number)
                        ->setSTREET($street)
                        ->setPOSTAL_CODE($postal_code)
                        ->setCOMPLEMENT($complement);

                    //Nous faisons la modification
                    $companyModified->update($id, "ID_COMPANY");
                    
                    //Nous redirigeons
                    $_SESSION['message'] = "Votre entreprise a été enregistrée avec succès !";
                    header('Location: /company');
                    exit;
                }
                else 
                {
                    //Le formulaire est incomplet

                }
                
                $form = new Form;

                $form->debutForm()
                    ->ajoutLabelFor('COMPANY_NAME','Nom de l\'entreprise :')
                    ->ajoutBr()
                    ->ajoutInput('text','COMPANY_NAME',['id' => 'COMPANY_NAME', 'class' => 'form-control', 'value' => $company->COMPANY_NAME])
                    ->ajoutBr()
                    ->ajoutLabelFor('ACTIVITY_SECTOR','Secteur d\'activité :')
                    ->ajoutBr()
                    ->ajoutInput('text','ACTIVITY_SECTOR',['id' => 'ACTIVITY_SECTOR', 'class' => 'form-control', 'value' => $company->ACTIVITY_SECTOR])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUMBER_OF_STUDENTS','Nombre d\'étudiant ayant déjà fait un stage :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUMBER_OF_STUDENTS',['id' => 'NUMBER_OF_STUDENTS', 'class' => 'form-control', 'value' => $company->NUMBER_OF_STUDENTS])
                    ->ajoutBr()
                    ->ajoutLabelFor('TOWN_NAME','Ville :')
                    ->ajoutBr()
                    ->ajoutInput('text','TOWN_NAME',['id' => 'TOWN_NAME', 'class' => 'form-control', 'value' => $company->TOWN_NAME])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUMBER','Numéro de l\'adresse :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUMBER',['id' => 'NUMBER', 'class' => 'form-control', 'value' => $company->NUMBER])
                    ->ajoutBr()
                    ->ajoutLabelFor('STREET','Rue :')
                    ->ajoutBr()
                    ->ajoutInput('text','STREET',['id' => 'STREET', 'class' => 'form-control', 'value' => $company->STREET])
                    ->ajoutBr()
                    ->ajoutLabelFor('POSTAL_CODE','Code postal :')
                    ->ajoutBr()
                    ->ajoutInput('text','POSTAL_CODE',['id' => 'POSTAL_CODE', 'class' => 'form-control', 'value' => $company->POSTAL_CODE])
                    ->ajoutBr()
                    ->ajoutLabelFor('COMPLEMENT','Complément d\'adresse :')
                    ->ajoutBr()
                    ->ajoutInput('text','COMPLEMENT',['id' => 'COMPLEMENT', 'class' => 'form-control', 'value' => $company->COMPLEMENT])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUM_SIRET','Numéro de Siret :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUM_SIRET',['id' => 'NUM_SIRET', 'class' => 'form-control', 'value' => $company->NUM_SIRET])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUM_SIREN','Numéro de Siren :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUM_SIREN',['id' => 'NUM_SIREN', 'class' => 'form-control', 'value' => $company->NUM_SIREN])
                    ->ajoutBr()
                    ->ajoutBr()
                    ->ajoutBouton('Modifier',['class' => 'btn btn-primary', 'type' => 'submit'])
                    ->finForm();

                    //Nous envoyons le contenue à la vue
                    $this->render('/company/modifier',['form' => $form->create()]);
            }
            else 
            {
                //L'utilisateur n'est pas connecté
                $_SESSION['error'] = "Une connexion est nécessaire pour accèder à la modification d'entreprise";
                header('Location: /user/login');
                exit;
            }
        }

        //Cette méthode permet d'ajouter une entreprise
        public function ajouter()
        {
            //Nous vérifions si l'utilisateur est connecté
            if (isset($_SESSION['user']) && !empty($_SESSION['user']['ID_USER']))
            {
                //L'utilisateur est connecté
                //Nous vérifions que le formulaire soit complet

                if(Form::validate($_POST, 
                ['COMPANY_NAME', 
                'ACTIVITY_SECTOR', 
                'NUMBER_OF_STUDENTS', 
                'TOWN_NAME', 
                'NUMBER', 
                'STREET', 
                'POSTAL_CODE', 
                'COMPLEMENT', 
                'NUM_SIRET', 
                'NUM_SIREN']))
                {
                    //Si le formulaire est complet
                    //Nous nous proteger contre les failles XSS et les injections SQL
                    //Avec strip_tags, htmlentities, htmlspecialchars
                    $company_name = strip_tags($_POST['COMPANY_NAME']);
                    $activity_sector = strip_tags($_POST['ACTIVITY_SECTOR']);
                    $number_of_students = strip_tags($_POST['NUMBER_OF_STUDENTS']);
                    $town_name = strip_tags($_POST['TOWN_NAME']);
                    $number = strip_tags($_POST['NUMBER']);
                    $street = strip_tags($_POST['STREET']);
                    $postal_code = strip_tags($_POST['POSTAL_CODE']);
                    $complement = strip_tags($_POST['COMPLEMENT']);
                    $num_siret = strip_tags($_POST['NUM_SIRET']);
                    $num_siren = strip_tags($_POST['NUM_SIREN']);

                    //Nous enregistrons notre annonce
                    $companyModel = new CompanyModel;

                    //Nous hydratons

                    $companyModel->setCOMPANY_NAME($company_name)
                        ->setACTIVITY_SECTOR($activity_sector)
                        ->setNUMBER_OF_STUDENTS($number_of_students)
                        ->setNUM_SIREN($num_siren)
                        ->setNUM_SIRET($num_siret)
                        ->setTOWN_NAME($town_name)
                        ->setNUMBER($number)
                        ->setSTREET($street)
                        ->setPOSTAL_CODE($postal_code)
                        ->setCOMPLEMENT($complement);

                    //Nous faisons le create
                    $companyModel->create();
                    
                    //Nous redirigeons
                    $_SESSION['message'] = "Votre entreprise a été enregistrée avec succès !";
                    header('Location: /company');
                    exit;
                }
                else 
                {
                    //Si le formulaire n'est pas complet
                    $_SESSION['error'] = !empty($_POST) ? "Le formulaire n'était pas complet lors de l'envoie de données." : "";
                    $company_name = isset($_POST['COMPANY_NAME']) ? strip_tags($_POST['COMPANY_NAME']) : '';
                    $activity_sector = isset($_POST['ACTIVITY_SECTOR']) ? strip_tags($_POST['ACTIVITY_SECTOR']) : '';
                    $number_of_students = isset($_POST['NUMBER_OF_STUDENTS']) ? strip_tags($_POST['NUMBER_OF_STUDENTS']) : '';
                    $town_name = isset($_POST['TOWN_NAME']) ? strip_tags($_POST['TOWN_NAME']) : '';
                    $number = isset($_POST['NUMBER']) ? strip_tags($_POST['NUMBER']) : '';
                    $street = isset($_POST['STREET']) ? strip_tags($_POST['STREET']) : '';
                    $postal_code = isset($_POST['POSTAL_CODE']) ? strip_tags($_POST['POSTAL_CODE']) : '';
                    $complement = isset($_POST['COMPLEMENT']) ? strip_tags($_POST['COMPLEMENT']) : '';
                    $num_siret = isset($_POST['NUM_SIRET']) ? strip_tags($_POST['NUM_SIRET']) : '';
                    $num_siren = isset($_POST['NUM_SIREN']) ? strip_tags($_POST['NUM_SIREN']) : '';
                }

                $form = new Form;

                $form->debutForm()
                    ->ajoutLabelFor('COMPANY_NAME','Nom de l\'entreprise :')
                    ->ajoutBr()
                    ->ajoutInput('text','COMPANY_NAME',['id' => 'COMPANY_NAME', 'class' => 'form-control', 'value' => $company_name])
                    ->ajoutBr()
                    ->ajoutLabelFor('ACTIVITY_SECTOR','Secteur d\'activité :')
                    ->ajoutBr()
                    ->ajoutInput('text','ACTIVITY_SECTOR',['id' => 'ACTIVITY_SECTOR', 'class' => 'form-control', 'value' => $activity_sector])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUMBER_OF_STUDENTS','Nombre d\'étudiant ayant déjà fait un stage :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUMBER_OF_STUDENTS',['id' => 'NUMBER_OF_STUDENTS', 'class' => 'form-control', 'value' => $number_of_students])
                    ->ajoutBr()
                    ->ajoutLabelFor('TOWN_NAME','Ville :')
                    ->ajoutBr()
                    ->ajoutInput('text','TOWN_NAME',['id' => 'TOWN_NAME', 'class' => 'form-control', 'value' => $town_name])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUMBER','Numéro de l\'adresse :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUMBER',['id' => 'NUMBER', 'class' => 'form-control', 'value' => $number])
                    ->ajoutBr()
                    ->ajoutLabelFor('STREET','Rue :')
                    ->ajoutBr()
                    ->ajoutInput('text','STREET',['id' => 'STREET', 'class' => 'form-control', 'value' => $street])
                    ->ajoutBr()
                    ->ajoutLabelFor('POSTAL_CODE','Code postal :')
                    ->ajoutBr()
                    ->ajoutInput('text','POSTAL_CODE',['id' => 'POSTAL_CODE', 'class' => 'form-control', 'value' => $postal_code])
                    ->ajoutBr()
                    ->ajoutLabelFor('COMPLEMENT','Complément d\'adresse :')
                    ->ajoutBr()
                    ->ajoutInput('text','COMPLEMENT',['id' => 'COMPLEMENT', 'class' => 'form-control', 'value' => $complement])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUM_SIRET','Numéro de Siret :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUM_SIRET',['id' => 'NUM_SIRET', 'class' => 'form-control', 'value' => $num_siret])
                    ->ajoutBr()
                    ->ajoutLabelFor('NUM_SIREN','Numéro de Siren :')
                    ->ajoutBr()
                    ->ajoutInput('text','NUM_SIREN',['id' => 'NUM_SIREN', 'class' => 'form-control', 'value' => $num_siren])
                    ->ajoutBr()
                    ->ajoutBr()
                    ->ajoutBouton('Ajouter',['class' => 'btn btn-primary', 'type' => 'submit'])
                    ->finForm();

                    $this->render('/company/ajouter',['form' => $form->create()]);
            }
            else
            {
                //L'utilisateur n'est pas connecté
                $_SESSION['error'] = "Une connexion est nécessaire pour accèder à la création d'entreprise";
                header('Location: /user/login');
                exit;
            }
        }

        public function supprimer($id)
        {
            if (isset($_SESSION['user']) && !empty($_SESSION['user']['ID_USER']))
            {
                //L'utilisateur est connecté
                //Nous vérifions que l'annonce existe dans la base de données
                //Nous instancions notre modèle
                $companyModel = new CompanyModel;

                //Nous cherchons l'annonce avec l'id
                $company = $companyModel->find("ID_COMPANY", $id);

                //Dans le cas où l'entreprise n'existe pas nous retournons à la liste des entreprises
                if (!$company)
                {
                    http_response_code(404);
                    $_SESSION['error'] = "L'annonce recherchée n'existe pas !";
                    header('Location: /company');
                    exit;
                }

                $companyModel->supprimerData($id,"ID_COMPANY");

                $this->render('/company/supprimer');
            }
            else 
            {
                //L'utilisateur n'est pas connecté
                $_SESSION['error'] = "Une connexion est nécessaire pour accèder à la suppression d'entreprise";
                header('Location: /user/login');
                exit;
            }
        }

    }

?>