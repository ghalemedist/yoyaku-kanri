    <h4>日時</h4>
    {{ $yoyakubis->title }}  
    <h4>時間を選択</h4>
    <select id="yoyakujikan_id" name="yoyakujikan_id" required>
    <option value="">選択してください</option>
    @foreach($yoyakubis->yoyakujikan as $item)
        <option value="{{ $item->id }}">{{ $item['format_time'] }}</option>
    @endforeach
    </select>
    <h4>予約の種類</h4>
    <div class="radio">     
        @foreach($yoyakutype as $value)
        <label>
            <div>
                <input type="radio" name="yoyakutype_id" value="{{ $value->id }}"
                required>
                <span class="">{{ $value->title }}</span>
                </div>
            </label> 
        @endforeach
    
    </div>   
   
    <h4>お名前 <div class="req"><p>※必須 </p></div></h4>
    <x-text-input 
        name="your_name" 
        type="text" 
        :value="old('your_name', session('yoyakuuser.your_name'))" 
        required />
    <x-input-error class="mt-2" :messages="$errors->get('your_name')" />
    <h4>フリガナ</h4>
    <x-text-input 
        name="your_kana" 
        type="text" 
        :value="old('your_kana', session('yoyakuuser.your_kana'))" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('your_kana')" />
    <h4>メールアドレス</h4>
    <x-text-input 
        name="your_email" 
        type="text" 
        :value="old('your_email', session('yoyakuuser.your_email'))" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('your_email')" />
    <h4>郵便番号</h4>
    <span class="p-country-name" style="display:none;">Japan</span>
    <x-text-input 
        name="postal_code" 
        type="text" 
        :value="old('postal_code', session('yoyakuuser.postal_code'))" 
        class="p-postal-code"
        />
    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
    <h4>住所</h4>
    <x-text-input 
        name="address_line" 
        type="text" 
        :value="old('address_line', session('yoyakuuser.address_line'))" 
        class="p-region p-locality p-street-address p-extended-address"
        />
    <x-input-error class="mt-2" :messages="$errors->get('address_line')" />
    <h4>電話番号</h4>
    <x-text-input 
        name="tel" 
        type="text" 
        :value="old('tel', session('yoyakuuser.tel'))" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('tel')" />
    <h4>ペットのお名前</h4>
    <x-text-input 
        name="pet_name" 
        type="text" 
        :value="old('pet_name', session('yoyakuuser.pet_name'))" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('pet_name')" />
    <h4>ペットの種類</h4>
    <div class="radio">  
        <label>
            <div>
                <input type="radio" name="pet_type" value="犬"
                
                checked="checked"
                >
                <span class="">犬</span>
            </div>
        </label>
        <label>
        <div>
            <input type="radio" name="pet_type" value="猫"
            @if(session('yoyakuuser.pet_type')  == '猫')
                checked
                @endif>
            <span class="">猫</span>
        </div>
        </label>
    
    <label>
        <div>
        <input type="radio" name="pet_type" value="その他"
        @if(session('yoyakuuser.pet_type') == 'その他')
            checked
            @endif
        >
        <span class="">その他</span>
        </div>
    </label>
    </div>        
    <h4>ペットの種類詳細</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message">{{ old('pet_message', session('yoyakuuser.pet_message')) }}
    </textarea>
    <h4>症状</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message2">{{ old('pet_message', session('yoyakuuser.pet_message2')) }}
    </textarea>
    <x-input-error class="mt-2" :messages="$errors->get('pet_message2')" />
    <h4>既往歴</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message3">{{ old('pet_message', session('yoyakuuser.pet_message3')) }}
    </textarea>          
    <h4>現在使用している薬</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message4">{{ old('pet_message', session('yoyakuuser.pet_message4')) }}
    </textarea>  

    <h4>ご要望・その他</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message5">{{ old('pet_message', session('yoyakuuser.pet_message5')) }}
    </textarea>       

@push('scripts')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
@endpush