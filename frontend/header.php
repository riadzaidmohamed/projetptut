<header>
    <?php
    function (){

        return '<div class="modal fade" id = "connexion" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" >
            <div class="modal-header" >
                <h4 class="modal-title" > Connexion</h4 >
                <button type = "button" class="close" data-dismiss = "modal" >&times;</button >
            </div >

            <!--Modal body-->
            <div class="modal-body" >
                <div class="container" style = "height: 100%" ><br >
                    <form action = "../backend/Clogin.php" method = "post" >
                        <div class="form-group" >
                            <label for="email" > Email address:</label >
                            <input type = "email" class="form-control" placeholder = "Enter email" id = "email" name = "Email" >
                        </div >
                        <div class="form-group" >
                            <label for="pwd" > Password:</label >
                            <input type = "password" class="form-control" placeholder = "Enter password" id = "pwd" name = "Mdp" >
                        </div >

                        <button type = "submit" name = "formconnexion" class="btn btn-primary" > Submit</button >
                    </form >
                </div >
            </div >
            <!--Modal footer-->
            <div class="modal-footer" >
                <button type = "button" class="btn btn-secondary" data-dismiss = "modal" > Close</button >
            </div >
        </div >
    </div >
</div >';
    }?>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <a class="navbar-brand" href="home.php">
            <img src="assets/Img/Logo.png" alt="Logo" class="logo">
        </a>
        <ul class="navbar-nav">
            <ul class="nav nav-pills">
                <li role="presentation" class="nav-item active">
                    <a class="nav-link" href="home.php">Actualité</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="club.php"> Le Club</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="">Les Equipes</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="administrative.php">Administratif</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="ourpartners.php">Nos Partenaires</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="shop.php">Notre Boutique</a>
                </li>
            </ul>
        </ul>

        <div class="nav justify-content-end">
            <?php
            session_start();

            if (!isset($_SESSION['login'])){
                echo'<form action="register.php" method="post">
                         <button type="submit" name="register" class="btn btn-primary">Inscription</button >
                     </form >
                     <button type = "button" class="btn btn-primary" data-toggle = "modal" data-target = "#connexion" >
                         Connexion
                     </button > ';
            }
            else{
                echo'<form action="../backend/Clogoff.php" method="post">
                         <button type="submit" name="deconnexion" class="btn btn-primary">Déconnexion</button>
                     </form>
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#co123">
                          Open modal
                     </button>';
            }
            ?>
        </div>
    </nav>

    <div class="modal fade" id="connexion">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Inscrption</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="">
                    <div class="container" style="height: 100%"><br>
                        <form action="../backend/Clogin.php" method="post">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" placeholder="Enter email" id="email" name="Email">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="Mdp">
                            </div>
                            <button type="submit" name="formconnexion" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="co123">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Mon profil</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="">
                    <table class="table" style="width: 100%">
                        <thead class="thead-dark">
                        <tr>
                            <th>Prenom</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $_SESSION["Prenom"]?></td>
                        </tr>
                        </tbody>
                        <thead class="thead-dark">
                        <tr>
                            <th>Nom</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> <?php echo $_SESSION["Nom"] ?> </td>
                        </tr>
                        </tbody>
                        <thead class="thead-dark">
                        <tr>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo  $_SESSION["Email"] ?></td>
                        </tr>
                        </tbody>
                        <thead class="thead-dark">
                        <tr>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php if ($_SESSION["Status"] == 0) {
                                    echo 'Non-licencié';
                                } else if ($_SESSION["Status"] == 1)  {
                                    echo 'Licencié';
                                }
                                else if ($_SESSION["Status"] == 2){
                                    echo 'Administrateur';
                                }?></td>
                        </tr>
                        </tbody>
                        <thead class="thead-dark">
                        <tr>
                            <th> Date de naissance </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> <?php echo $_SESSION["DateN"]?></td>
                        </tr>
                        </tbody>
                        <thead class="thead-dark">
                        <tr>
                            <th> Equipe </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> <?php echo $_SESSION["NomE"]?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</header>