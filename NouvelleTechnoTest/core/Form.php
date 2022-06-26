<?php

    namespace App\core;

    class Form 
    {
        private $formCode = '';

        //Méthode permettant de générer le formulaire HTML
        public function create()
        {
            return $this->formCode;
        }

        //Méthode qui permet de valider que tous les champs obligatoire du formulaire ont été remplis
        //Nous la mettons en static pour appeler la méthode sans à avoir a instancier l'objet
        //Elle retourne true si tous les champs proposés sont remplis, sinon, elle retourne false
        //Le paramètre form est issu d'un formulaire $_POST ou $_GET
        //Le paramètre fields est un tableau qui liste les champs obligatoire
        public static function validate(array $form, array $fields)
        {
            //Nous parcourons les champs
            foreach($fields as $field)
            {
                //Nous vérifions si le champ est absent ou vide dans le formulaire
                if (!isset($form[$field]) || empty($form[$field]))
                {
                    //Nous sortons de la boucle en retournant false
                    return false;
                }
                return true;
            }
        }

        //Cette méthode ajoute les attributs envoyés à la balise
        //Les attributs sont dans un tableau ['class' => 'form-control', 'required' => true]
        //Cette méthode retourne une chaine de caractère
        private function ajoutAttributs(array $attribute): string
        {
            //Nous initalisons une chaine de caractères
            $str = '';

            //Nous listons les attributs "courts"
            $short = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

            //Nous bouclons sur le tableau d'attributs
            foreach($attribute as $attribut => $value)
            {
                //Nous vérifions si c'est un attribut court et qu'il est à true
                if (in_array($attribut, $short) && $value == true)
                {
                    //L'attribut est un attribut court
                    $str .= " $attribut";
                }
                else
                {
                    //Nous ajoutons attribut="value"
                    $str .= " $attribut=\"$value\"";
                }
            }

            return $str;
        }

        //Cette méthode va faire la balise d'ouverture du formulaire
        //Le paramètre method est la méthode du formulaire : POST ou GET
        //Le paramètre action est l'action du formulaire
        //Le paramètre attribute correspond aux attributs que nous voudrions passer à notre formulaire
        //Nous retournons le formulaire
        public function debutForm(string $method = 'post', string $action = '', array $attribute = []): self
        {
            //Nous créons la balise form
            $this->formCode .= "<form action='$action' method='$method'";

            //Nous ajoutons les attributs éventuels
            $this->formCode .= $attribute ? $this->ajoutAttributs($attribute) : '';

            //Nous fermons la balise form
            $this->formCode .= '>';

            return $this;
        }

        //Cette méthode permet de construire la balise de fermeture du formulaire
        public function finForm(): self
        {
            $this->formCode .= "</form>";
            return $this;
        }

        //Méthode permettant de générer des labels
        public function ajoutLabelFor(string $for, string $text, array $attribute = []): self
        {
            //Nous ouvrons la balise
            $this->formCode .= "<label for='$for'";

            //Nous ajoutons les attributs
            $this->formCode .= $attribute ? $this->ajoutAttributs($attribute) : '';

            //Nous ajoutons le texte
            $this->formCode .= ">$text</label>";

            return $this;
        }

        //Méthode permettant de générer des inputs
        public function ajoutInput(string $type, string $name, array $attribute = []): self
        {
            //Nous ouvrons la balise
            $this->formCode .= "<input type='$type' name='$name'";

            //Nous ajoutons les attributs
            $this->formCode .= $attribute ? $this->ajoutAttributs($attribute) : '>';

            //Nous ajoutons le texte
            $this->formCode .= ">";

            return $this;
        }

        //Méthode permettant de générer un textarea
        public function ajoutTextarea(string $name, string $value = '', array $attribute = []) : self
        {
            //Nous ouvrons la balise
            $this->formCode .= "<textarea name='$name'";

            //Nous ajoutons les attributs
            $this->formCode .= $attribute ? $this->ajoutAttributs($attribute) : '';

            //Nous ajoutons le texte
            $this->formCode .= ">$value</textarea>";

            return $this;
        }

        //Méthode permettant de générer des balises select
        public function ajoutSelect(string $name, array $options = [], array $attribute = []): self
        {
            //Nous ouvrons la balise
            $this->formCode .= "<select name='$name'";

            //Nous ajoutons les attributs
            $this->formCode .= $attribute ? $this->ajoutAttributs($attribute) : '>';

            //Nous fermons la balise
            $this->formCode .= ">";

            //Nous ajoutons les options
            foreach($options as $value => $text)
            {
                $this->formCode .= "<option value=\"$value\">$text</option>";
            }

            //Nous fermons le select
            $this->formCode .= "</select>";

            return $this;
        }

        //Méthode permettant de générer un bouton
        public function ajoutBouton(string $text, array $attribute) : self
        {
            //Nous ouvrons la balise
            $this->formCode .= "<button ";

            //Nous ajoutons les attributs
            $this->formCode .= $attribute ? $this->ajoutAttributs($attribute) : '>';

            //Nous fermons la balise
            $this->formCode .= ">$text</button>";

            return $this;
        }

        //Méthode permettant de générer un br
        public function ajoutBr() : self
        {
            $this->formCode .= "<br>";

            return $this;
        }
    }

?>