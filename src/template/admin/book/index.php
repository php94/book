{include common/header@php94/admin}
<h1 class="py-3">文档管理</h1>
<div class="d-flex flex-column gap-3">
    <div>
        <a class="btn btn-primary" href="{echo $router->build('/php94/book/admin/book/create')}">添加文档</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mb-0 d-table-cell">
            <thead>
                <tr>
                    <th>标题</th>
                    <th>操作</th>
                    <th>查看</th>
                </tr>
            </thead>
            <tbody>
                {foreach $books as $vo}
                <tr>
                    <td>
                        <span>{$vo.title}</span>
                    </td>
                    <td>
                        <a href="{echo $router->build('/php94/book/admin/page/index', ['book_id'=>$vo['id']])}">内容管理</a>
                        <a href="{echo $router->build('/php94/book/admin/book/update', ['id'=>$vo['id']])}">编辑</a>
                        <a href="{echo $router->build('/php94/book/admin/book/delete', ['id'=>$vo['id']])}" onclick="return prompt('删除操作不可恢复，会连带删除该文档下的所有内容，确定删除吗？请输入[123456]确认', '')==='123456'">删除</a>
                    </td>
                    <td>
                        <a href="{echo $router->build('/php94/book/home/book', ['book'=>$vo['name']])}" target="_blank">查看</a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
{include common/footer@php94/admin}