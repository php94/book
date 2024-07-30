{include common/header@php94/admin}
<h1 class="py-3">内容管理</h1>
<div class="my-3">
    <a class="btn btn-primary" href="{echo $router->build('/php94/book/admin/page/create', ['book_id'=>$book['id']])}" role="button">添加内容</a>
</div>
<div class="m-2">
    <style>
        .handlerx .handler {
            display: none;
        }

        .handlerx:hover .handler {
            display: inline-block;
        }
    </style>
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
    {function subpage($pages, $pid, $level, $router)}
    {foreach $pages as $vo}
    {if $vo['pid'] == $pid}
    {if getsubs($pages, $vo['id'])}
    <details open>
        <summary class="handlerx">
            <span>{$vo.title}</span>
            <span class="handler">
                <a href="{echo $router->build('/php94/book/admin/page/rank', ['type'=>'up', 'id'=>$vo['id']])}">上移</a>
                <a href="{echo $router->build('/php94/book/admin/page/rank', ['type'=>'down', 'id'=>$vo['id']])}">下移</a>
                <a href="{echo $router->build('/php94/book/admin/page/update', ['id'=>$vo['id']])}">编辑</a>
                <a href="{echo $router->build('/php94/book/admin/page/delete', ['id'=>$vo['id']])}" onclick="return prompt('删除操作不可恢复，删除内容会连带删除该内容下的内容，确定删除吗？请输入[123456]确认', '')==='123456'">删除</a>
            </span>
        </summary>
        <div class="ms-1 ps-3 border-start border-secondary-subtle">{echo subpage($pages, $vo['id'], $level+1, $router)}</div>
    </details>
    {else}
    <div class="handlerx">
        <span>📄 {$vo.title}</span>
        <span class="handler">
            <a href="{echo $router->build('/php94/book/admin/page/rank', ['type'=>'up', 'id'=>$vo['id']])}">上移</a>
            <a href="{echo $router->build('/php94/book/admin/page/rank', ['type'=>'down', 'id'=>$vo['id']])}">下移</a>
            <a href="{echo $router->build('/php94/book/admin/page/update', ['id'=>$vo['id']])}">编辑</a>
            <a href="{echo $router->build('/php94/book/admin/page/delete', ['id'=>$vo['id']])}" onclick="return prompt('删除操作不可恢复，删除内容会连带删除该内容下的内容，确定删除吗？请输入[123456]确认', '')==='123456'">删除</a>
        </span>
    </div>
    {echo subpage($pages, $vo['id'], $level+1, $router)}
    {/if}
    {/if}
    {/foreach}
    {/function}
    {echo subpage($pages, 0, 0, $router)}
</div>
{include common/footer@php94/admin}