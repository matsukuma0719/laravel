@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">顧客情報の編集</h2>

    <div class="grid grid-cols-2 gap-8">

        {{-- 左カラム：編集フォーム --}}
        <form method="POST" action="{{ route('customers.update', $customer->customer_id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-sm">氏名（漢字）</label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">フリガナ</label>
                <input type="text" name="kana" value="{{ old('kana', $customer->kana) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">性別</label>
                <select name="gender" class="form-select w-full">
                    <option value="">選択してください</option>
                    <option value="male" {{ old('gender', $customer->gender) === 'male' ? 'selected' : '' }}>男性</option>
                    <option value="female" {{ old('gender', $customer->gender) === 'female' ? 'selected' : '' }}>女性</option>
                    <option value="other" {{ old('gender', $customer->gender) === 'other' ? 'selected' : '' }}>その他</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm">生年月日</label>
                <input type="date" name="birthday" value="{{ old('birthday', $customer->birthday) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">電話番号</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">メールアドレス</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">住所</label>
                <input type="text" name="address" value="{{ old('address', $customer->address) }}" class="form-input w-full">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-sm">初回来店日</label>
                    <input type="date" name="first_visit" value="{{ old('first_visit', $customer->first_visit) }}" class="form-input w-full">
                </div>
                <div>
                    <label class="block font-medium text-sm">最終来店日</label>
                    <input type="date" name="last_visit" value="{{ old('last_visit', $customer->last_visit) }}" class="form-input w-full">
                </div>
            </div>

            <div>
                <label class="block font-medium text-sm">来店回数</label>
                <input type="number" name="visit_count" value="{{ old('visit_count', $customer->visit_count) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">紹介者</label>
                <input type="text" name="referrer" value="{{ old('referrer', $customer->referrer) }}" class="form-input w-full">
            </div>

            <div>
                <label class="block font-medium text-sm">備考 / 特記事項</label>
                <textarea name="notes" rows="4" class="form-textarea w-full">{{ old('notes', $customer->notes) }}</textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    更新する
                </button>
            </div>
        </form>

        {{-- 右カラム：利用履歴（読み取り専用） --}}
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">直近の利用履歴（3件）</h3>

            @foreach ($customer->reservations->sortByDesc('date')->take(3) as $rsv)
                <div class="border p-4 rounded-lg bg-gray-50 space-y-2">
                    <p><strong>実施日:</strong> {{ $rsv->date }}</p>
                    <p><strong>キャンペーン適用:</strong> {{ $rsv->campaign_applied ? '✔' : '—' }}</p>
                    <p><strong>施術メニュー:</strong> {{ $rsv->menu_name }}</p>
                    <p><strong>施術内容:</strong> {{ $rsv->details }}</p>
                    <p><strong>使用薬剤:</strong> {{ $rsv->products }}</p>
                    <p><strong>担当者:</strong> {{ $rsv->emp_name }}</p>
                    <p><strong>希望スタイル:</strong> {{ $rsv->style }}</p>
                    <p><strong>髪質・頭皮:</strong> {{ $rsv->hair_condition }}</p>
                    <p><strong>アレルギー:</strong> {{ $rsv->allergies }}</p>
                    <p><strong>顧客の感想:</strong> {{ $rsv->feedback }}</p>
                    <p><strong>次回提案:</strong> {{ $rsv->next_plan }}</p>
                    <p><strong>備考:</strong> {{ $rsv->memo }}</p>

                    {{-- 画像がある場合 --}}
                    @if (!empty($rsv->images))
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($rsv->images as $img)
                                <img src="{{ $img }}" class="w-24 h-24 object-cover rounded border">
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
