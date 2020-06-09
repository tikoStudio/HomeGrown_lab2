<?php
    if (!empty($_POST)) {
        header("Location: namedCommunities.php?cn=" . $_POST['search']);
    }
?>
<header>
    <form action="" method="POST">
        <div class="form__field form__field__search">
            <a href="namedCommunities.php?cn=" class="headerlink"> <img src="images/search.svg" alt="mail icon"
                    class="form__icon"></a>
            <input type="text" id="search" name="search" placeholder="Look for communities">
        </div>
    </form>
</header>

<script>
    document.querySelector('#search').addEventListener('keyup', (e) => {
        let queryparam = document.querySelector('#search').value
        document.querySelector('.headerlink').setAttribute('href', `namedCommunities.php?cn=${queryparam}`)
    })
</script>