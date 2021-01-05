<?php

use Illuminate\Database\Seeder;

class TravelBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('travel_blogs')->insert(
            array(
                0 =>
                array(
                        'id' => 1,
                        'zone_id' => 14,
                        'title' => 'Shwe Dagon Pagoda',
                        'overview' => 'The Shwedagon Pagoda was constructed more than 2,600 years ago by the Mon King and people, which would make it the oldest Buddhist stupa in the world.',
                        'history' => 'The Shwedagon Pagoda was constructed more than 2,600 years ago by the Mon King and people, which would make it the oldest Buddhist stupa in the world.',
                        'main_image' => 'travelBlogs/1602040175.png',
                        'check_in_point' => '<p> Shwe Dagon Pagoda -</p><img width="1024" height="768" src="https://upload.wikimedia.org/wikipedia/commons/1/16/Shwedagon_pagoda.jpg"<p>Kalaw</p>'

                ),
                1 =>
                array(
                        'id' => 2,
                        'zone_id' => 11,
                        'title' => 'Kalaw',
                        'overview' => 'ကလောဟူသော အမည်သည် ဒေသခံလူမျိုးများဖြစ်သော ပလောင်လူမျိုးများ၏ကလောက် ဟူသော အသံထွက်မှ ဖြစ်ပေါ်လာသည်။ ပလောင်စကားအရ ကလောက်သည် ဒယ်အိုး(သို့)ဇလုံ ဟု အဓိပ္ပာယ်ရသည်။ ကလောမြို့အား အရပ်လေးမျက်နှာ တောင်တန်းများဝန်းရံနေပုံမှာ ဒယ်အိုးပုံစံနှင့် တူသောကြောင့်ထိုသို့ ခေါ်ဆိုခဲ့ကြသည်။',
                        'history' => 'ကလောဟူသော အမည်သည် ဒေသခံလူမျိုးများဖြစ်သော ပလောင်လူမျိုးများ၏ကလောက် ဟူသော အသံထွက်မှ ဖြစ်ပေါ်လာသည်။ ပလောင်စကားအရ ကလောက်သည် ဒယ်အိုး(သို့)ဇလုံ ဟု အဓိပ္ပာယ်ရသည်။ ကလောမြို့အား အရပ်လေးမျက်နှာ တောင်တန်းများဝန်းရံနေပုံမှာ ဒယ်အိုးပုံစံနှင့် တူသောကြောင့်ထိုသို့ ခေါ်ဆိုခဲ့ကြသည်။',
                        'main_image' => 'travelBlogs/1602040175.png',
                        'check_in_point' => '<p> Kalaw -</p><img width="1024" height="768" src="https://upload.wikimedia.org/wikipedia/commons/1/16/Shwedagon_pagoda.jpg"<p>Kalaw</p>'

                ),
                2 =>
                array(
                        'id' => 3,
                        'zone_id' => 9,
                        'title' => 'Kyaik Htee Yoe',
                        'overview' => 'ကျိုက်ထိုမြို့နယ်ရှိ ကျိုက်ထီးရိုးစေတီတော်သည် အရှေ့ရိုးမတောင်တန်း အပါအဝင်ဖြစ်သော ပေါင်းလောင်းတောင်ပေါ်တွင် တည်ရှိ၍မြန်မာနိုင်ငံတွင် တန်ခိုးကြီးသော စေတီတစ်ဆူဖြစ်သည်။ ကျိုက်ထီးရိုးစေတီကို အစွဲပြု၍ စေတီတော်တည်ရှိရာတောင်ကို ကျိုက်ထီးရိုးတောင်ဟုခေါ်ကြသည်။',
                        'history' => 'ကျိုက်ထိုမြို့နယ်ရှိ ကျိုက်ထီးရိုးစေတီတော်သည် အရှေ့ရိုးမတောင်တန်း အပါအဝင်ဖြစ်သော ပေါင်းလောင်းတောင်ပေါ်တွင် တည်ရှိ၍မြန်မာနိုင်ငံတွင် တန်ခိုးကြီးသော စေတီတစ်ဆူဖြစ်သည်။ ကျိုက်ထီးရိုးစေတီကို အစွဲပြု၍ စေတီတော်တည်ရှိရာတောင်ကို ကျိုက်ထီးရိုးတောင်ဟုခေါ်ကြသည်။',
                        'main_image' => 'travelBlogs/1602040175.png',
                       'check_in_point' => '<p> Kyaik Htee Yoe -</p><img width="1024" height="768" src="https://upload.wikimedia.org/wikipedia/commons/1/16/Shwedagon_pagoda.jpg"<p>Kalaw</p>'

                ),
            )
        );
    }
}
