<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>StayEase Hotel</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=DM+Sans:wght@300;400&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--gold:#C9A84C;--ink:#0E0D0B;--mist:#8C8778;--cream:#FAF8F3}
body{font-family:'DM Sans',sans-serif;background:var(--ink);color:var(--cream)}

nav{position:fixed;top:0;left:0;right:0;z-index:9;display:flex;justify-content:space-between;align-items:center;padding:24px 56px;background:linear-gradient(to bottom,rgba(14,13,11,.95),transparent)}
.logo{font-family:'Playfair Display',serif;font-size:20px;color:var(--gold);letter-spacing:.06em}
nav a{color:var(--mist);text-decoration:none;font-size:12px;letter-spacing:.12em;text-transform:uppercase;margin-left:28px;transition:color .2s}
nav a:hover{color:var(--cream)}
.cta{border:1px solid var(--gold)!important;color:var(--gold)!important;padding:9px 22px;border-radius:2px;transition:background .25s!important}
.cta:hover{background:var(--gold);color:var(--ink)!important}

.hero{min-height:100vh;display:flex;align-items:flex-end;padding:0 56px 80px;position:relative;overflow:hidden}
.hero-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1800&q=80') center/cover;z-index:0}
.hero-bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(14,13,11,1) 10%,rgba(14,13,11,.45) 60%,rgba(14,13,11,.7) 100%)}
.hero-inner{position:relative;z-index:1;display:grid;grid-template-columns:1fr auto;align-items:flex-end;gap:48px;width:100%;max-width:1300px}
.eyebrow{display:flex;align-items:center;gap:12px;margin-bottom:20px}
.eyebrow span{font-size:10px;letter-spacing:.22em;text-transform:uppercase;color:var(--gold)}
.eyebrow::before{content:'';display:block;width:32px;height:1px;background:var(--gold)}
h1{font-family:'Playfair Display',serif;font-size:clamp(44px,5.5vw,80px);font-weight:400;line-height:1.08;animation:up .9s ease both}
h1 i{color:#E8D08A}
.sub{margin:20px 0 36px;font-size:15px;color:var(--mist);line-height:1.75;font-weight:300;max-width:480px;animation:up .9s .1s ease both}
.btns{display:flex;gap:16px;animation:up .9s .2s ease both}
.btn{padding:14px 32px;font-size:12px;letter-spacing:.13em;text-transform:uppercase;text-decoration:none;border-radius:2px;transition:.25s}
.btn-g{background:var(--gold);color:var(--ink);font-weight:500}
.btn-g:hover{background:#E8D08A}
.btn-o{border:1px solid rgba(201,168,76,.4);color:var(--gold)}
.btn-o:hover{border-color:var(--gold);background:rgba(201,168,76,.08)}
.card{background:rgba(14,13,11,.75);backdrop-filter:blur(18px);border:1px solid rgba(201,168,76,.2);border-radius:4px;padding:28px 24px;min-width:240px;animation:up .9s .3s ease both}
.card-label{font-size:9px;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:18px}
.stat{display:flex;justify-content:space-between;align-items:baseline;padding:10px 0;border-bottom:1px solid rgba(201,168,76,.08)}
.stat:last-child{border:none}
.stat-k{font-size:12px;color:var(--mist);font-weight:300}
.stat-v{font-family:'Playfair Display',serif;font-size:18px;color:var(--cream)}

.strip{display:flex;border-top:1px solid rgba(201,168,76,.15);border-bottom:1px solid rgba(201,168,76,.15)}
.strip-item{flex:1;padding:44px 40px;border-right:1px solid rgba(201,168,76,.15);transition:background .3s;cursor:default}
.strip-item:last-child{border:none}
.strip-item:hover{background:rgba(201,168,76,.04)}
.s-num{font-family:'Playfair Display',serif;font-size:11px;color:rgba(201,168,76,.4);margin-bottom:16px}
.s-title{font-size:16px;color:var(--cream);margin-bottom:8px;letter-spacing:-.01em}
.s-desc{font-size:13px;color:var(--mist);line-height:1.65;font-weight:300}

.numbers{display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid rgba(201,168,76,.15)}
.n-item{padding:60px 40px;text-align:center;border-right:1px solid rgba(201,168,76,.15)}
.n-item:last-child{border:none}
.n-val{font-family:'Playfair Display',serif;font-size:56px;color:#E8D08A;line-height:1}
.n-lbl{font-size:10px;letter-spacing:.18em;text-transform:uppercase;color:var(--mist);margin-top:10px}

footer{display:flex;justify-content:space-between;align-items:center;padding:32px 56px;border-top:1px solid rgba(201,168,76,.15)}
footer p{font-size:11px;color:rgba(140,135,120,.5);letter-spacing:.06em}
footer a{font-size:11px;color:var(--mist);text-decoration:none;letter-spacing:.1em;text-transform:uppercase;margin-left:24px}
footer a:hover{color:var(--gold)}

@keyframes up{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:none}}
.reveal{opacity:0;transform:translateY(24px);transition:opacity .8s ease,transform .8s ease}
.reveal.on{opacity:1;transform:none}
@media(max-width:900px){
  nav{padding:20px 24px}.hero{padding:0 24px 60px}
  .hero-inner{grid-template-columns:1fr}.card{display:none}
  .strip{flex-direction:column}.numbers{grid-template-columns:repeat(2,1fr)}
  footer{flex-direction:column;gap:16px;text-align:center;padding:28px 24px}
}
</style>
</head>
<body>

<nav>
  <div class="logo">StayEase</div>
  <div>
    @auth
      <a href="{{ route('dashboard') }}">Dashboard</a>
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}" class="cta">Register</a>
    @endauth
  </div>
</nav>

<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-inner">
    <div>
      <div class="eyebrow"><span>Hospitality Management OS</span></div>
      <h1>Run your hotel<br>like a <i>business</i>,<br>not a spreadsheet.</h1>
      <p class="sub">Bookings, guests, payments, and reports — unified in one elegant system built for operators who demand clarity.</p>
      <div class="btns">
        @auth
          <a href="{{ route('dashboard') }}" class="btn btn-g">Go to Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="btn btn-g">Sign In</a>
          <a href="{{ route('register') }}" class="btn btn-o">Create Account</a>
        @endauth
      </div>
    
</section>

<div class="strip reveal">
  <div class="strip-item">
    <div class="s-num">01</div>
    <div class="s-title">Room Management</div>
    <div class="s-desc">Real-time availability, maintenance flags, and room-type config in one view.</div>
  </div>
  <div class="strip-item">
    <div class="s-num">02</div>
    <div class="s-title">Reservation Workflow</div>
    <div class="s-desc">Intake to check-out: deposits, assignments, and automated guest reminders.</div>
  </div>
  <div class="strip-item">
    <div class="s-num">03</div>
    <div class="s-title">Payments & Reports</div>
    <div class="s-desc">ADR, RevPAR, and transaction history with a full audit trail — always on.</div>
  </div>
</div>

<div class="numbers reveal">
  <div class="n-item"><div class="n-val">48+</div><div class="n-lbl">Rooms Tracked</div></div>
  <div class="n-item"><div class="n-val">2×</div><div class="n-lbl">Faster Check-In</div></div>
  <div class="n-item"><div class="n-val">98%</div><div class="n-lbl">System Uptime</div></div>
  <div class="n-item"><div class="n-val">∞</div><div class="n-lbl">Booking History</div></div>
</div>

<footer>
  <p>&copy; 2025 StayEase Hotel MS</p>
  <div>
    <a href="#">Privacy</a>
    <a href="#">Terms</a>
    <a href="#">Support</a>
  </div>
</footer>

<script>
const io=new IntersectionObserver(es=>es.forEach(e=>e.isIntersecting&&(e.target.classList.add('on'),io.unobserve(e.target))),{threshold:.12});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
</script>
</body>
</html>