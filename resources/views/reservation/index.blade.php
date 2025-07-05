<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">担当者一覧</h2>
    </x-slot>

    <div class="p-6">
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">名前</th>
                    <th class="border px-4 py-2">役割</th>
                    <th class="border px-4 py-2">対応メニュー</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $e)
                    <tr>
                        <td class="border px-4 py-2">{{ $e->name }}</td>
                        <td class="border px-4 py-2">{{ $e->role }}</td>
                        <td class="border px-4 py-2">{{ $e->menu_list }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
