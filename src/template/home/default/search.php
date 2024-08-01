{include home/default/header@php94/book}
<div class="container">
    <div class="py-3">
        <?php
        function searchstr($str, $q): string
        {
            if (is_string($str) && strlen($str) && is_string($q) && strlen($q)) {
                $res = [];
                while (($ps1 = mb_stripos($str, $q)) !== false) {
                    $ps2 = mb_stripos($str, $q, $ps1 + mb_strlen($q));
                    $pre = $ps1;
                    while (($ps2 !== false) && ($ps2 - $pre < 40)) {
                        $pre = $ps2;
                        $ps2 = mb_stripos($str, $q, $ps2 + mb_strlen($q));
                    }

                    $res[] = mb_substr($str, max($ps1 - 20, 0), $pre + mb_strlen($q) + 20 - max($ps1 - 20, 0));
                    $str = mb_substr($str, $pre + mb_strlen($q));
                }
                return '..' . implode('....', $res) . '..';
            }
            return $str;
        }
        $q = trim($request->get('q', ''));
        ?>
        <table class="table table-bordered">
            {foreach $searchs as $vo}
            <tr>
                <td>
                    <div class="position-relative">
                        <div>
                            <a href="{echo $router->build('/php94/book/home/page', ['book'=>$book['name'], 'id'=>$vo['id'], 'q'=>$q])}" class="fw-bold stretched-link">{$vo['title']}</a>
                        </div>
                        <div>{:searchstr(strip_tags($vo['body']), $q)}</div>
                    </div>
                </td>
            </tr>
            {/foreach}
        </table>
    </div>
</div>
<style>
    .mark,
    mark {
        padding: 0;
        color: red;
        background-color: yellow;
    }
</style>
<script src="{echo $router->build('/php94/book/home/file', ['file'=>'markjs'])}"></script>
<script>
    $(function() {
        $(".container").mark("{$q}");
    });
</script>
{include home/default/footer@php94/book}