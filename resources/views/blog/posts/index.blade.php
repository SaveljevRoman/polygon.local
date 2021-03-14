<table>
    @foreach($items as $item)
        <td>{{ $item->id }}</td>
        <td>{{ $item->title }}</td>
        <td>{{ $item->created_at }}</td>
    @endforeach
</table>
