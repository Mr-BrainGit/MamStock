<?php

class User
{
  private $name;
  private $password;
  private $role;
  private $phone;
  private $image;

  public function __construct($name, $password, $role, $phone, $image=null)
  {
    $this->setName($name);
    $this->setPassword($password);
    $this->setRole($role);
    $this->setPhone($phone);
    $this->setImage($image);
  }

  public function getUsername()
  {
    return $this->name;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getRole()
  {
    return $this->role;
  }

  public function getPhone()
  {
    return $this->phone;
  }

  public function getImage()
  {
    return $this->image;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function setRole($role)
  {
    $this->role = $role;
  }

  public function setPhone($phone)
  {
    $this->phone = $phone;
  }

  public function setImage($image)
  {
    $this->image = $image;
  }

  public static function getAllUsers()
  {
    include 'db-connect.php';
    $requete = $bdd->prepare("SELECT * FROM users");
    $requete->execute();
    return $requete->fetchAll();
  }

  public static function modifyImageDirectory(string $file, string $tmpName, string $directory, string $username)
  {
    if (strlen($file) !== 0) {
      $extension = substr(strrchr($file, "."), 1);
      $newName = $username . '.' . $extension;
      $directoryTmp = $tmpName;
      $directoryFinal =  $directory . $newName;
      return $directoryFinal;
    } else {
      $imgTable = ['avatar.png', 'avatar4.png', 'avatar5.png'];
      shuffle($imgTable);
      foreach ($imgTable as $img) {
        return $directoryFinal = "../../dist/img/$img";
      }
    }
  }

  public static function createNewUser(User $user)
  {
    include 'db-connect.php';
    $phone = $user->getPhone();

    $requete = $bdd->prepare("SELECT * FROM users WHERE phone = '$phone'");
    $requete->execute();
    $users = $requete->fetchAll();

    if (count($users) === 0) {
      $pdoStat = $bdd->prepare('INSERT INTO users VALUES (:idUser, :username, :password, :role, :phone, :image)');
      $pdoStat->bindValue(':idUser', NULL);
      $pdoStat->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
      $pdoStat->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
      $pdoStat->bindValue(':role', $user->getRole(), PDO::PARAM_STR);
      $pdoStat->bindValue(':phone', $user->getPhone(), PDO::PARAM_STR);
      $pdoStat->bindValue(':image', $user->getImage(), PDO::PARAM_STR);
      $insertOK = $pdoStat->execute();

      if ($insertOK) {
        echo " ";
      } else {
        echo "Ajout echoué";
      }
    } else {
      $response = "Le user à été déja créé";
      return $response;
    }
  }


  public static function isConnected(): bool
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return !empty($_SESSION['connecte']);
  }

  public static function forcedConnexion(string $directory)
  {
    if (!User::isConnected()) {
      header("Location: $directory");
      exit;
    }
  }

  public static function connexionSuccess(string $directory, string $role, string $image)
  {
    session_start();
    $_SESSION['connecte'] = 1;
    $_SESSION['MM_Username'] = $role;
    $_SESSION['MM_Image'] = $image;
    header("Location: $directory");
    exit;
  }

  public static function loadConnexion(array $table, string $username, string $password)
  {
    foreach ($table as $attribute) {
      if ($attribute['username'] == $username && password_verify($password, $attribute['password'])) {
        return $attribute;
      }
    }
  }


  /**Méthode pour supprimer un user */
  public static function delete($idUser)
  {
    include 'db-connect.php';

    $requete = $bdd->prepare("DELETE FROM users WHERE idUser = $idUser");
    $requete->execute();
  }

  //**Méthode pour faire la mise a jour d'un user */
  public static function update(User $user, $id)
  {
    include 'db-connect.php';

    $username = $user->getUsername();
    $password = $user->getPassword();
    $role = $user->getRole();
    $phone = $user->getPhone();
    $image = $user->getImage();


    $sql = "UPDATE users SET
                username = '$username',
                password = '$password',
                role = '$role',
                phone = '$phone',
                image = '$image'
                WHERE idUser = $id";

    // Prepare statement
    $stmt = $bdd->prepare($sql);

    // execute the query
    $retour = $stmt->execute();

    if ($retour) {
      return 1;
    } else {
      return 0;
    }
  }

}
