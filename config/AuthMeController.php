<?php


abstract class AuthMeController {



    # Change values to your mysql database login credentials

    const HOST = "opluckycraft.it";

    const USERNAME = "minecraft";

    const PASSWORD = "34gAGozv2U0Pq97TCg";

    const DATABASE = "minecraft";

    const AUTHME_TABLE = 'authme';

    function is_session(){
        if (isset($_SESSION['id'])){
            return true;
        }else{
            return false;
        }
    }

    /**

     * Entry point function to check supplied credentials against the AuthMe database.

     *

     * @param string $username the username

     * @param string $password the password

     * @return bool true iff the data is correct, false otherwise

     */

    function checkPassword($username, $password) {

        if (is_scalar($username) && is_scalar($password)) {

            $hash = $this->getHashFromDatabase($username);

            if ($hash) {

                return $this->isValidPassword($password, $hash);

            }

        }

        return false;

    }



    /**

     * Returns whether the user exists in the database or not.

     *

     * @param string $username the username to check

     * @return bool true if the user exists; false otherwise

     */

    function isUserRegistered($username) {

        $mysqli = $this->getAuthmeMySqli();

        if ($mysqli !== null) {

            $stmt = $mysqli->prepare('SELECT 1 FROM ' . self::AUTHME_TABLE . ' WHERE username = ?');

            $stmt->bind_param('s', $username);

            $stmt->execute();

            return $stmt->fetch();

        }



        // Defensive default to true; we actually don't know

        return true;

    }



    /**

     * Registers a player with the given username.

     *

     * @param string $username the username to register

     * @param string $password the password to associate to the user

     * @param string $email the email (may be empty)

     * @return bool whether or not the registration was successful

     */

    function register($username, $password, $email) {

        $email = $email ? $email : 'your@email.com';

        $mysqli = $this->getAuthmeMySqli();

        if ($mysqli !== null) {

            $hash = $this->hash($password);

            $stmt = $mysqli->prepare('INSERT INTO ' . self::AUTHME_TABLE . ' (username, realname, password, email, ip) '

                . 'VALUES (?, ?, ?, ?, ?)');

            $username_low = strtolower($username);

            $stmt->bind_param('sssss', $username_low, $username, $hash, $email, $_SERVER['REMOTE_ADDR']);

            return $stmt->execute();

        }

        return false;

    }



    /**

     * Hashes the given password.

     *

     * @param $password string the clear-text password to hash

     * @return string the resulting hash

     */

    protected abstract function hash($password);



    /**

     * Checks whether the given password matches the hash.

     *

     * @param $password string the clear-text password

     * @param $hash string the password hash

     * @return boolean true if the password matches, false otherwise

     */

    protected abstract function isValidPassword($password, $hash);



    /**

     * Returns a connection to the database.

     *

     * @return mysqli|null the mysqli object or null upon error

     */

    private function getAuthmeMySqli() {

        // CHANGE YOUR DATABASE DETAILS HERE BELOW: host, user, password, database name

        error_reporting(0);

        $mysqli = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASE);

        if (mysqli_connect_error()) {

          echo '<div class="alert alert-warning" role="alert"><h4 class="alert-heading"><b>Database Error</b></h4><p>Error connecting to the database.<br> Please report this to an admin<p></div>';

          #Uncomment this below to see the exact error code

          #printf('<div class="alert alert-dark" role="alert">Could not connect to AuthMe database. Errno: %d, error: "%s"<hr><p>Maybe wrong login credentials for database</div>', mysqli_connect_errno(), mysqli_connect_error());

          error_reporting(E_ERROR | E_WARNING | E_PARSE);

          return null;

        }

        return $mysqli;

    }



    /**

     * Retrieves the hash associated with the given user from the database.

     *

     * @param string $username the username whose hash should be retrieved

     * @return string|null the hash, or null if unavailable (e.g. username doesn't exist)

     */

    private function getHashFromDatabase($username) {

        $mysqli = $this->getAuthmeMySqli();

        if ($mysqli !== null) {

            $stmt = $mysqli->prepare('SELECT password FROM ' . self::AUTHME_TABLE . ' WHERE username = ?');

            $stmt->bind_param('s', $username);

            $stmt->execute();

            $stmt->bind_result($password);

            if ($stmt->fetch()) {

                return $password;

            }

        }

        return null;

    }



}

