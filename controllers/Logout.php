<?php
session_start();
session_destroy();
?>
<script>
    alert("Session Expired!");
    location.href = "../index.php";
</script>
<?php
?>