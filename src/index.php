<html>

<!--   --><?php
//    include_once "page_parts/head.php";
//    ?><!---->-->
<head>
    <title>Δήλωση Διπλωματικών</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="/pras_pc.ico">
    <link rel="shortcut icon" type="image/png" href="img/Circle-icons-computer.svg.png">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/login_style.css">
</head>

<body>
<div class="container">

    <?php
    include_once "page_parts/header.php"
    ?>

    <div class="home-page main leave-top-gap">
        <div class="grid col-one-half mq2-col-full">
            <h1>Σύστημα Δήλωσης <br>
                Διπλωματικών Εργασιών <br>
            </h1><br>

            <p>Καλώς ήρθατε στη πλατφόρμα δήλωσης διπλωματικών εργασιών στην οποία οι καθηγητές και οι φοιτητές του
                ΜΠΕΣ θα αλληλεπιδρούν κατά τη διάρκεια εκπόνησης διπλωματικής εργασίας.<br>
                Στόχος είναι η ενίσχυση της εκπαιδευτικής διαδικασίας, προσφέροντας στους συμμετέχοντες ένα δυναμικό
                περιβάλλον αλληλεπίδρασης
                και συνεχούς επικοινωνίας εκπαιδευτή εκπαιδευόμενου. Ειδικότερα, επιτρέπει στους φοιτητές να
                ενημερώνονται σχετικά με τα διαθέσιμα
                θέματα διπλωματικών εργασιών και να δηλώνουν το ενδιαφέρον τους και οι καθηγητές έχουν τη δυνατότητα
                να ενημερώνονται σε ποιο στάδιο βρίσκεται η εκπόνηση της διπλωματικής εργασίας.
            </p>
            <p></p>
        </div>

        <div class="slider grid col-one-half mq2-col-full">


            <div class="form">
                <h2>Σύνδεση Χρήστη</h2>
                <form class="login-form">
                    <input type="text" placeholder="username"/>
                    <input type="password" placeholder="password"/>
                    <button>ΕΙΣΟΔΟΣ</button>
                    <p class="message">Δεν είσαι μέλος? <a href="register.php">Κάνε εγγραφή</a></p>
                </form>
            </div>


        </div>
    </div>
    <br>
</div>
</body>
</html>

<?php
include_once"page_parts/footer.php"
?>