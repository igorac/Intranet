<?php 
    defined('BASEPATH') OR exit('URL inválida.');
?>

<!-- Main Footer -->
<footer class="main-footer">
    <!-- Default to the left -->
    <strong>Copyright &copy; <span id="ano-copyright"></span>  <a href="#" class="color-primary">Company</a>.</strong> Todos os direitos Reservados.
</footer>

<script>
  
  var yearNow = new Date();
  spanElement = document.querySelector('#ano-copyright');
  spanElement.innerText = yearNow.getFullYear(); 


</script>