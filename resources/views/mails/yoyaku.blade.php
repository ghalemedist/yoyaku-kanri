<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $mailData['title'] }}</title>
    <style>
      
      /*All the styling goes here*/
      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; 
      }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; 
      }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; 
      }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 580px;
        padding: 10px; 
      }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #ffffff;
        border-radius: 3px;
        width: 100%; 
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 10px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 16px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 5px; 
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; 
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }
      .mt2 {
        margin-top: 20px; 
      }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; 
      }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; 
      }

      .btn-primary table td {
        background-color: #3498db; 
      }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; 
      }

      
      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table.body h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; 
        }
        table.body p,
        table.body ul,
        table.body ol,
        table.body td,
        table.body span,
        table.body a {
          font-size: 16px !important; 
        }
        table.body .wrapper,
        table.body .article {
          padding: 10px !important; 
        }
        table.body .content {
          padding: 0 !important; 
        }
        table.body .container {
          padding: 0 !important;
          width: 100% !important; 
        }
        table.body .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; 
        }
        table.body .btn table {
          width: 100% !important; 
        }
        table.body .btn a {
          width: 100% !important; 
        }
        table.body .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; 
        }
      }
      .info-table {
        margin-top: 20px;
      }
      .info-table tr td:first-child {
        width: 30%;
      }
      .info-table tr td {
        padding-bottom: 10px;
      }
      .change-btn {
        background: #3498db;
        padding: 10px 20px;
        color: #fff !important;
        text-decoration: none;
        font-size: 20px;
        margin-right: 20px;
      }
      .cancel-btn {
        background: red;
        padding: 10px 20px;
        color: #fff !important;
        text-decoration: none;
        font-size: 20px;
      }

      

    </style>
  </head>
  <body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <table role="presentation" class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <h2>{{ $mailData['data']->your_name }} 様</h2>
                        @if($mailData['action'] == 'store')
                          <h2>この度は、ご予約ありがとうございます。</h2>
                          <h2>ご予約内容は以下のとおり承りました。</h2>
                          <h2>ご予約日時にご来院をお待ちしております。</h2>
                        @else
                          <h2>この度は、ご予約ありがとうございます。</h2>
                          <h2>ご予約内容は以下のとおり変更いたしました。</h2>
                          <h2>ご予約日時にご来院をお待ちしております。</h2>
                        @endif
                      </td>
                      @php
                       $data = $mailData['data'] 
                      @endphp
                      <tr>
                        <td>
                          <table class="info-table">
                            <tr>
                              <td>ご予約日時</td>
                              <td>{{ $data->yoyakujikan->yoyakubi->title }} {{ $data->yoyakujikan->format_time }}</td>
                            </tr>
                            <tr>
                              <td>予約の種類</td>
                              <td> {{ $mailData['data']->yoyakutype->title }}</td>
                            </tr>
                            <tr>
                              <td>お名前</td>
                              <td> {{ $mailData['data']->your_name }}</td>
                            </tr>
                            <tr>
                              <td>フリガナ</td>
                              <td>{{ $data->your_kana }}</td>
                            </tr>
                            <tr>
                              <td>メールアドレス</td>
                              <td>{{ $data->your_email?$data->your_email:'なし' }}</td>
                            </tr>
                            <tr>
                              <td>郵便番号</td>
                              <td>{{ $data->postal_code?$data->postal_code:'なし' }}</td>
                            </tr>
                            <tr>
                              <td>住所</td>
                              <td>{{ $data->address_line?$data->address_line:'なし' }}</td>
                            </tr>
                            <tr>
                              <td>電話番号</td>
                              <td>{{ $data->tel?$data->tel:'なし' }}</td>
                            </tr>
                            <tr>
                              <td>ペットのお名前</td>
                              <td>{{ $data->pet_name?$data->pet_name:'なし' }}</td>
                            </tr>
                            <tr>
                              <td>ペットの種類</td>
                              <td>{{ $data->pet_type?$data->pet_type:'なし' }}</td>
                            </tr>
                            <tr>
                              <td>ペットの種類詳細</td>
                              <td>{{ $data->pet_message?$data->pet_message:'なし' }}</td>
                            </tr>
                            @if(!empty($data->pet_message2))
                            <tr>
                              <td>症状</td>
                              <td>{{ $data->pet_message2?$data->pet_message2:'なし' }}</td>
                            </tr>
                            @endif
                            @if($data->pet_message3)
                            <tr>
                              <td>既往歴</td>
                              <td>{{ $data->pet_message3?$data->pet_message3:'なし' }}</td>
                            </tr>
                            @endif
                            @if($data->pet_message4)
                            <tr>
                              <td>現在使用している薬</td>
                              <td>{{ $data->pet_message4?$data->pet_message4:'なし' }}</td>
                            </tr>
                            @endif
                            <tr>
                              <td>ご要望・その他</td>
                              <td>{{ $data->pet_message5?$data->pet_message5:'なし' }}</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="mt2">日程の変更やキャンセルの場合、</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p class="mt2">
                            <a href="{{ $mailData['yoyaku_url'].'/appointment-update/'.$data->token_id }}" class="change-btn">変更</a> 
                            <a href="{{ $mailData['yoyaku_url'].'/appointment-cancel/'.$data->token_id }}" class="cancel-btn">キャンセル</a>
                          </p>
                        </td>
                      </tr>
                  </table>
                </td>
              </tr>
            </table>
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>