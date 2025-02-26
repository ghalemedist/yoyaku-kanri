<h4>日時</h4>
    <p>日付を選択
    <input type="text" name="yoyakubi" value="{{ $yoyakuuser->yoyakujikan->yoyakubi->date }}" id="datepicker" class="hasDatepickerss"></p>
    <p>時間を選択</p>
    <select id="yoyakujikan_id" name="yoyakujikan_id" required>
    <option value="">選択してください</option>
   
    @foreach ( $currentJikans as $item)
        <option value="{{ $item->id }}" 
        @if ($yoyakuuser->yoyakujikan->id == $item->id)
            {{ __('selected') }}
        @endif
        >{{ $item->format_time }}</option>
    @endforeach
    </select>
    
    <h4>予約の種類</h4>
    <div class="radio">  
        @foreach($yoyakutype as $item)
        <label>
            <div>
                <input type="radio" name="yoyakutype_id" 
                value="{{ $item->id }}"
                {{ ($item->id == $yoyakuuser->yoyakutype_id)?'checked':'' }}
                >
                <span class="">{{ $item->title }}</span>
                </div>
            </label> 
        @endforeach        
    </div>       
    <h4>お名前</h4>
    <x-text-input 
        name="your_name" 
        type="text" 
        :value="old('your_name', $yoyakuuser->your_name)" 
        required />
    <x-input-error class="mt-2" :messages="$errors->get('your_name')" />
    <h4>フリガナ</h4>
    <x-text-input 
        name="your_kana" 
        type="text" 
        :value="old('your_kana', $yoyakuuser->your_kana)" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('your_kana')" />
    <h4>メールアドレス</h4>
    <x-text-input 
        name="your_email" 
        type="text" 
        :value="old('your_email', $yoyakuuser->your_email)" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('your_email')" />
    <h4>郵便番号</h4>
    <span class="p-country-name" style="display:none;">Japan</span>
    <x-text-input 
        name="postal_code" 
        type="text" 
        :value="old('postal_code', $yoyakuuser->postal_code)" 
        class="p-postal-code"
        />
    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
    <h4>住所</h4>
    <x-text-input 
        name="address_line" 
        type="text" 
        :value="old('address_line', $yoyakuuser->address_line)" 
        class="p-region p-locality p-street-address p-extended-address"
        />
    <x-input-error class="mt-2" :messages="$errors->get('address_line')" />
    <h4>電話番号</h4>
    <x-text-input 
        name="tel" 
        type="text" 
        :value="old('tel', $yoyakuuser->tel)" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('tel')" />
    
    <h4>ペットの種類</h4>
    <div class="radio">      
        <label>
            <div>
                <input type="radio" name="pet_type" value="犬"
                @if (isset($yoyakuuser->pet_type) && $yoyakuuser->pet_type == '犬')
                    checked
                @endif
                >
                <span class="">犬</span>
            </div>
        </label>
        <label>
        <div>
            <input type="radio" name="pet_type" value="猫" 
            @if (isset($yoyakuuser->pet_type) && $yoyakuuser->pet_type == '猫')
            checked
            @endif
            >
            <span class="">猫</span>
        </div>
        </label>
        <label>
        <div>
        <input type="radio" name="pet_type" value="その他"
        @if (isset($yoyakuuser->pet_type) && $yoyakuuser->pet_type == 'その他')
            checked
        @endif
        >
        <span class="">その他</span>
        </div>
    </label>
    </div>  
    <h4>ペットのお名前</h4>
    <x-text-input 
        name="pet_name" 
        type="text" 
        :value="old('pet_name', $yoyakuuser->pet_name)" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('pet_name')" />

    <h4>ペットの年齢</h4>
    <x-text-input 
        name="pet_year" 
        type="text" 
        :value="old('pet_year', $yoyakuuser->pet_year)" 
        />
    <x-input-error class="mt-2" :messages="$errors->get('pet_year')" />

    <h4>ペットの性別</h4>
    <div class="radio">      
        <label>
            <div>
                <input type="radio" name="pet_gender" value="オス"
                @if (isset($yoyakuuser->pet_gender) && $yoyakuuser->pet_gender == 'オス')
                    checked
                @endif
                >
                <span class="">オス</span>
            </div>
        </label>
        <label>
        <div>
            <input type="radio" name="pet_gender" value="メス"
            @if (isset($yoyakuuser->pet_gender) && $yoyakuuser->pet_gender == 'メス')
                    checked
                @endif>
            <span class="">メス</span>
        </div>
        </label>
    </div>  
    
    <h4>ペットの種類詳細</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message">{{ old('tel', $yoyakuuser->pet_message) }}
    </textarea>        
    <h4>症状</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message2">{{ old('tel', $yoyakuuser->pet_message2) }}
    </textarea>          
    <h4>既往歴</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message3">{{ old('tel', $yoyakuuser->pet_message3) }}
    </textarea>          
    <h4>現在使用している薬</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message4">{{ old('tel', $yoyakuuser->pet_message4) }}
    </textarea>          
    <h4>ご要望・その他</h4>
    <textarea cols="40" rows="10" class="" aria-invalid="false" 
        name="pet_message5">{{ old('tel', $yoyakuuser->pet_message5) }}
    </textarea>   
    <h4>ステータス</h4>
            <div class="radio">        
            <label>
            <div>
                <input type="radio" name="yoyaku_status" value="1" @if (isset($yoyakuuser->yoyaku_status) && $yoyakuuser->yoyaku_status == '1')
                    checked
                @endif
                >
                <span class="">

                    アクティブ</span>
                </div>
            </label>
            <label>
                <div>
                <input type="radio" name="yoyaku_status" value="0"
                @if (isset($yoyakuuser->yoyaku_status) && $yoyakuuser->yoyaku_status == '0')
                    checked
                @endif
                >
                <span class="">キャンセル</span>
                </div>
            </label>
        </div>     
    <div class="person-div">
    <div style="width: 300px;">
    <input class="btn btn-primary" type="submit" value="修正完了！" name="btn">
    </div>
</div>

@push('scripts')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $(function() {

        $("#datepicker").datepicker({
            minDate: 0, // 過去日付は選択NG
            maxDate: '+2m', // 3か月以上先は選択NG
            language: 'ja',
            dateFormat: "yy/m/d(D)", 
            daysOfWeekDisabled: [0],
            beforeShowDay: closeOnHoliday,
            onSelect: function(date, picker){
                var date = new Date(date)
                var selectedDate = date.getFullYear() + '-' +('0' + (date.getMonth() + 1)).slice(-2) + '-' +('0' + date.getDate()).slice(-2);
                // var selectedDate = dt.getFullYear()+'-'+dt.getMonth().slice(-2)+'-'+dt.getDay().slice(-2)
                var filteredJikans = yoyakubi.find((val) => val.date == selectedDate)
                var options = '<option value="">選択してください</option>'
                options+=filteredJikans.yoyakujikan.map((val) => '<option value="'+val.id+'">'+val.format_time+'</option>')
                $("#yoyakujikan_id").html(options)
            }
        
        });

        function closeOnHoliday(date){
            var day = date.getDay();
            if(day == 0 || day == 4)
            return [false]
            return [true]
        }

        var yoyakubi = @php echo json_encode($yoyakubi) @endphp;

    });
  </script>
@endpush