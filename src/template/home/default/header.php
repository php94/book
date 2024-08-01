<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="applicable-device" content="pc,mobile">
    <title>{$seo['title']??''}</title>
    <meta name="keywords" content="{$seo['keywords']??''}">
    <meta name="description" content="{$seo['description']??''}">
    <script src="{echo $router->build('/php94/book/home/file', ['file'=>'jquery'])}"></script>
    <script src="{echo $router->build('/php94/book/home/file', ['file'=>'bsjs'])}"></script>
    <link href="{echo $router->build('/php94/book/home/file', ['file'=>'bscss'])}" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        img {
            max-width: 100%;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body class="position-relative">
    <div class="position-absolute start-0 end-0 top-0 overflow-visible d-flex align-items-center align-self-center align-content-center bg-success" style="height: 50px;z-index: 110;color: #fff;">
        <div style="font-size: 1.5em;margin-left: 10px;" onclick="this.parentNode.nextElementSibling.nextElementSibling.style.left=this.parentNode.nextElementSibling.nextElementSibling.style.left=='240px'?'0':'240px';this.parentNode.nextElementSibling.style.left=this.parentNode.nextElementSibling.style.left=='-240px'?'0':'-240px';"><span style="margin-right:2px">&nbsp;<img src="{echo $router->build('/')}static/book.png" width="25" alt=""></span>{$book.title}</div>
    </div>
    <div class="position-absolute bottom-0 overflow-auto" style="width: 240px;left: 0px;top: 50px;background: #f5faff;border-top: 1px solid #f1f9fa;">
        <div class="m-2">
            <form action="{echo $router->build('/php94/book/home/search')}" method="get">
                <input type="hidden" name="book" value="{$book.name}">
                <input type="search" name="q" value="{$request->get('q')}" onchange="this.form.submit()" class="form-control" placeholder="搜索：">
            </form>
        </div>
        <div class="m-2 d-none" id="navs">
            <?php
            function getsubs($data, $pid): array
            {
                $res = [];
                foreach ($data as $vo) {
                    if ($vo['pid'] == $pid) {
                        $res[] = $vo;
                    }
                }
                return $res;
            }
            ?>
            {function subpage($book, $pages, $pid, $level, $router, $request)}
            {foreach $pages as $vo}
            {if $vo['pid'] == $pid}
            {if getsubs($pages, $vo['id'])}
            <details>
                <summary>{$vo.title}</summary>
                <div class="ms-1 ps-3 border-start border-secondary-subtle">{echo subpage($book, $pages, $vo['id'], $level+1, $router, $request)}</div>
            </details>
            {else}
            <a href="{echo $router->build('/php94/book/home/page', ['book'=>$book['name'], 'id'=>$vo['id']])}" class="d-flex gap-1 {if $request->get('id')==$vo['id']}bg-primary-subtle{/if}">
                <div>📄</div>
                <div>{$vo.title}</div>
            </a>
            {echo subpage($book, $pages, $vo['id'], $level+1, $router, $request)}
            {/if}
            {/if}
            {/foreach}
            {/function}
            {echo subpage($book, $pages, 0, 0, $router, $request)}
        </div>
        <script>
            $("#navs a.bg-primary-subtle").parents('details').attr("open", "open");
            $("#navs").removeClass("d-none");
            $("#navs a").on('hover', function() {
                $(this).addClass("bg-light-subtle");

            })
        </script>
    </div>
    <div class="position-absolute end-0 bottom-0 overflow-auto" style="left: 240px;top: 50px;z-index: 100;">