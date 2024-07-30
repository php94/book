{if !$book['copy']}
<script>
    document.oncontextmenu = function() {
        return false
    };
    document.onkeydown = function(e) {
        e = window.event || e;
        var k = e.keyCode;
        if ((e.ctrlKey == true && k == 83) || (e.ctrlKey == true && k == 85) || k == 123) {
            e.keyCode = 0;
            e.returnValue = false;
            e.cancelBubble = true;
            return false;
        }
    }
    document.body.className = document.body.className + " user-select-none d-print-none";
</script>
{/if}
{if $book['water']}
<script>
    document.body.style.backgroundImage = "url('{echo $book['water']}')";
</script>
{/if}