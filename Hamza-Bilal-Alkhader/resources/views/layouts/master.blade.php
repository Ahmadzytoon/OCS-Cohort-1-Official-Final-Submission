<!DOCTYPE html>
<html lang="en">

@include('layouts.partials.head')

{{-- Mentory Chat Widget (Global) --}}
<style>
 #mentoryChatBtn{
  position: fixed;
  left: 18px;
  right: auto;
  bottom: 18px;
  z-index: 9999;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  border: 0;
  background: #5fcf80;
  color: #fff;
  box-shadow: 0 10px 26px rgba(0,0,0,.18);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size: 22px;
}

#mentoryChatBox{
  position: fixed;
  left: 18px;
  right: auto;
  bottom: 86px;
  z-index: 9999;
  width: 360px;
  max-width: calc(100vw - 36px);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 18px 40px rgba(0,0,0,.18);
  display: none;
  background: #fff;
}

  .mc-head{
    background:#5fcf80;
    color:#fff;
    padding: 12px 14px;
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .mc-head .title{ font-weight: 700; }
  .mc-head button{
    background: transparent;
    border:0;
    color:#fff;
    font-size: 18px;
    line-height: 1;
  }

  .mc-body{
    height: 320px;
    overflow:auto;
    padding: 12px;
    background:#fafafa;
  }

  .mc-msg{ margin-bottom: 10px; }
  .mc-who{ font-size: 12px; color:#6c757d; margin-bottom: 3px; }
  .mc-bubble{
    display:inline-block;
    padding: 10px 12px;
    border-radius: 14px;
    border: 1px solid #e6e6e6;
    background:#fff;
    max-width: 92%;
    white-space: pre-wrap;
  }
  .mc-bubble.me{ background:#eafff0; border-color:#d6f7e3; }

  .mc-foot{
    padding: 10px;
    border-top: 1px solid #eee;
    display:flex;
    gap: 8px;
    background:#fff;
  }
  .mc-foot input{
    flex: 1;
    border-radius: 12px;
  }
  .mc-foot button{
    border-radius: 12px;
    background:#5fcf80;
    color:#fff;
    border:0;
    padding: 0 14px;
  }
</style>

<div id="mentoryChatBox">
  <div class="mc-head">
    <div class="title">Mentory Chat</div>
    <button type="button" id="mcClose">✕</button>
  </div>

  <div id="mcBody" class="mc-body">
    <div class="mc-msg">
      <div class="mc-who">Assistant</div>
      <div class="mc-bubble">Hi! How can I help you?</div>
    </div>
  </div>

  <div class="mc-foot">
    @csrf
    <input id="mcInput" class="form-control" placeholder="Type a message..." autocomplete="off">
    <button type="button" id="mcSend">Send</button>
  </div>
</div>

<button id="mentoryChatBtn" type="button" title="Chat">
      <i class="bi bi-robot"></i>
</button>

<script>
  const btn = document.getElementById('mentoryChatBtn');
  const box = document.getElementById('mentoryChatBox');
  const closeBtn = document.getElementById('mcClose');
  const body = document.getElementById('mcBody');
  const input = document.getElementById('mcInput');
  const send = document.getElementById('mcSend');

  function addMsg(who, text){
    const wrap = document.createElement('div');
    wrap.className = 'mc-msg';

    const w = document.createElement('div');
    w.className = 'mc-who';
    w.textContent = who;

    const b = document.createElement('div');
    b.className = 'mc-bubble' + (who === 'You' ? ' me' : '');
    b.textContent = text;

    wrap.appendChild(w);
    wrap.appendChild(b);
    body.appendChild(wrap);
    body.scrollTop = body.scrollHeight;
  }

  function toggleChat(open){
    box.style.display = open ? 'block' : 'none';
    if(open) setTimeout(() => input.focus(), 50);
  }

  btn.addEventListener('click', () => {
    const isOpen = box.style.display === 'block';
    toggleChat(!isOpen);
  });

  closeBtn.addEventListener('click', () => toggleChat(false));

  async function sendMsg(){
    const msg = input.value.trim();
    if(!msg) return;

    addMsg('You', msg);
    input.value = '';
    send.disabled = true;

    try{
      const token = document.querySelector('input[name="_token"]').value;

      const res = await fetch("{{ route('chat.send') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ message: msg })
      });

      const data = await res.json();

      if(!res.ok){
        addMsg('Assistant', data.reply || 'Error');
      }else{
        addMsg('Assistant', data.reply || 'No reply');
      }

    }catch(e){
      addMsg('Assistant', 'Network error');
    }finally{
      send.disabled = false;
    }
  }

  send.addEventListener('click', sendMsg);
  input.addEventListener('keydown', (e) => {
    if(e.key === 'Enter') sendMsg();
  });
</script>


  <body class="index-page d-flex flex-column min-vh-100">
  
    @include('layouts.partials.nav')

    <main class="main">
      @yield('content')
    </main>

      @include('layouts.partials.footer')
  </body>
</html>
