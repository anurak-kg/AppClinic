<table>
    <tr>
        <td>พนักงาน</td>
        <td>
            {{$user}}
        </td>
    </tr>
    <tr>
        <td>สาขา</td>
        <td>
            @foreach($branch as $item)
                {{$item->branch_name}},
            @endforeach
        </td>
    </tr>
    <tr>
        <td>ชื่อ คลินิค</td>
        <td></td>
    </tr>
    <tr>
        <td>APP KEY</td>
        <td>{{$appKey}}</td>
    </tr>
    <tr>
        <td>URL ::</td>
        <td>{{Request::url()}}</td>
    </tr>
    <tr>
        <td>SERVER_ADDR</td>
        <td>{{$_SERVER['SERVER_ADDR']}}</td>
    </tr>
    <tr>
        <td>SERVER_NAME</td>
        <td>{{$_SERVER['SERVER_NAME']}}</td>
    </tr>
</table>