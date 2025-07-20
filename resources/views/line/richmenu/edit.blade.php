<form action="{{ route('richmenu.update', $menu->id) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- input等各種編集項目 -->
    <button type="submit">保存</button>
</form>
