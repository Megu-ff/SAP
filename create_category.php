<?php
include('functions/connect.php');
include('header.php');
?>

<section class="bg-primary pb-3"><br>
    <div class="container block">
        <div class='row'>
            <div class='col-6'>
                <?php
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo '<h3><a href="category.php?id=">Category name</a></h3> Category description goes here';
                        echo '</td>';
                ?>
            </div>
            <div class='col-6'>
                <?php
                        echo '<td class="rightpart">';                
                            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                        echo '</td>';
                echo '</tr>';
                ?>
            </div>
        </div>

    </div>
</section>


    <!-- Footer -->
    <?php
	    include_once 'footer.php';
	?>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
        <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/freelancer.min.js"></script>

</body>

</html>