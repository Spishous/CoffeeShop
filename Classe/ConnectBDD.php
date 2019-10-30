<?php
class Base
{
    public $dns;
    private $pdo;

    public function __construct()
    {
        $this->dns = 'mysql:host=mysql-rlucas974.alwaysdata.net;dbname=rlucas974_coffeeshop;port=3306;charset=utf8';
        $this->pdo = new PDO($this->dns, 'rlucas974', 'm9741223');
    }
    public function __toString()
    { }

    public function TestClientConnexion($user, $pass)
    {
        $stmt = $this->pdo->query("SELECT * FROM `Client` WHERE (`Username`='$user' OR Email = '$user') AND `Password`='$pass'");
        if ($stmt->rowCount() == 1) {
            $donnees = $stmt->fetch();
            if (isset($_SESSION["logconnect"]) == false) {
                $_SESSION["logconnect"] = true;
            }
            $_SESSION["nomsession"] = $donnees['Nom'];
            $_SESSION["prenomsession"] = $donnees['Prenom'];
            $_SESSION["Telephonesession"] = $donnees['Telephone'];
            $_SESSION["Index_Adressesession"] = $donnees['Index_Adresse'];
            $_SESSION["Usernamesession"] = $donnees['Username'];
            $_SESSION["Emailsession"] = $donnees['Email'];
            $_SESSION["Statutsession"] = $donnees['Statut'];
            //$_SESSION["indexPansession"] = $donnees['Index_Panier'];
            $_SESSION["indexClientsession"] = $donnees['ID_Client'];
            return "1";
        } else {
            return "0";
        }
    }

    public function Deconnexion()
    {
        if (isset($_SESSION["logconnect"])) {
            $_SESSION["logconnect"] = false;
        }
    }
    public function AfficheArticleFilter($filter = "")
    {
        if ($filter == "") {
            $stmt = $this->pdo->query("SELECT * FROM `Produit` WHERE 1");
            if ($stmt->rowCount() > 0) {
                $countart=0;
                while ($donnees = $stmt->fetch()) {
                    echo "<div class='list-article-unite'><img alt src='src/img/" . $donnees["Image"] . "'>
                    <p class='tit-art-unit'>" . $donnees["Libellé"] . "</p>
                    <p class='prix-art-unit'>" . $donnees["Prix"] . "€</p>
                    <span class='ajouter-panier' idarticle='".$donnees["ID_Produit"]."'>Ajouter</span>
                    </div>";
                    $countart+=1;
                }
                echo "<div style='margin-top: 30px;'><p class='nb-choice'>".$countart." choix</p>
                </div>";
            }
        } else {
            echo "qsd";
        }
    }

    public function ajoutuser($user,$mail,$pwd)
    {
        $this->pdo->query("INSERT INTO `Client` (`ID_Client`, `Nom`, `Prenom`, `Telephone`, `Index_Adresse`, `Username`, `Email`, `Password`, `Statut`) VALUES (NULL, NULL, NULL, NULL, '0', '$user','$mail','$pwd', 'Client');");
    }
    public function TranscriptLocalphp(){
        if(isset($_SESSION["article"])){
            return $_SESSION["article"];
        }
    }
    public function stringToPanier(){
        $chaine=$this->TranscriptLocalphp();
        $pos=0;
        $tot=0;
        for ($i=0;$i<(substr_count($chaine, "A"));$i++) {
            $where=substr($chaine, stripos($chaine, "A", $pos)+1, stripos($chaine, "b", $pos)-stripos($chaine, "A", $pos)-1);
            $quant=substr($chaine, stripos($chaine, "b", $pos)+1, stripos($chaine, "e", $pos)-stripos($chaine, "b", $pos)-1);
            $stmt=$this->pdo->query("SELECT * FROM `Produit` WHERE `ID_Produit`='$where'");
            if ($stmt->rowCount() == 1) {
                $donnees = $stmt->fetch();
                $tot = $tot + ($donnees["Prix"] * $quant);
                echo "<div>" . $quant . " " . $donnees["Libellé"] . " = " . ($donnees["Prix"] * $quant) . "€ </div>";
            }
            $pos=stripos($chaine, "e", $pos)+1;
        }
        if ($tot == 0) {
            echo "Votre panier est vide ! ";
            ?> <button id='menu' onClick=""> <a href="template.php?page=menu"> Menu </a> </button> <?php
        } else {
            echo "<br> Total à régler : " . $tot . "Eur <br>";
            ?> <input type="button" id="videPanButt" value="Vider le panier"> <?php
        }
        
    }

    public function createPanier()
    {
        $sessClient = $_SESSION["indexClientsession"];
        $panExist = $this->pdo->query("SELECT * FROM `Panier` WHERE Index_Client = '$sessClient' ");
        
        if ($panExist->rowCount() > 0) {
            
            $donnees = $panExist->fetch();
            //echo "existe".$donnees["produit"];
        }else {
            //echo "existe pas";
            $this->pdo->query("INSERT INTO `Panier` (`ID_Panier`, `produit`, `Index_Client`) VALUES (NULL, '', '$sessClient')");
        }      
    }
}
