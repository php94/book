{include home/default/header@php94/book}
<div class="container">
    <h1 class="py-4">{$book.title}</h1>
    <div>{echo $book['body']}</div>
</div>
{include home/default/footer@php94/book}