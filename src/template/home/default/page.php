{include home/default/header@php94/book}
<div class="container">
    <h1 class="py-4">{$page['title']}</h1>
    <div class="pb-3">{echo $page['body']}</div>
</div>
{if $request->get('q', '')}
<style>
    .mark,
    mark {
        padding: 0;
        color: red;
        background-color: yellow;
    }
</style>
<script src="https://cdn.bootcdn.net/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
<script>
    $(function() {
        $(".container").mark("{$request->get('q', '')}");
        setTimeout(function() {
            $('html, body').animate({
                scrollTop: $('mark').first().offset().top
            }, 500);
        }, 200)
        $('table').addClass('table table-bordered border-dark mx-auto')
    });
</script>
{/if}
{include home/default/footer@php94/book}