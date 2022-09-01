<div id="profile">
    <div class="wrapper20">
        <div class="userInfo">
            <div class="userImg">
                <img src="{{ asset('uploads/profil') }}/thumb_{{Auth::user()->foto}}" rel="user">
            </div>
            <div class="userTxt">
                <span class="fullname">{{ Auth::user()->jabatan }}</span> <i class="fa fa-chevron-right"></i><br>
                <span class="username">{{ Auth::user()->name }}</span>
            </div>
        </div> <!-- /userInfo -->
        <div class="userStats">
            <div class="uStat graph">
                <div class="stat-name">
                    Pemohon <!--<div class="stat-badge">+3</div>-->
                </div>
                <div class="stat-number">{{ $pemohon }}</div>
            </div>
            <div class="uStat graph">
                <div class="stat-name">
                    Dlm Proses <!--<div class="stat-badge">+4</div>-->
                </div>
                <div class="stat-number">{{ $proses }}</div>
            </div>
            <div class="uStat graph">
                <div id="stats_visits" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>
                <div class="stat-name">
                    Ditolak
                </div>
                <div class="stat-number">{{ $tolak }}</div>

            </div>
            <div class="uStat graph">
                <div id="stats_balance" class="stat-chart" values="0,0,0,0,0,0,0,0,0,0,0,0,0"></div>
                <div class="stat-name">
                    Disetujui
                </div>
                <div class="stat-number">{{ $setuju }}</div>
            </div>
        </div>

        <i class="fa fa-bars icon-nav-mobile"></i>

    </div>
</div> <!-- /profile -->