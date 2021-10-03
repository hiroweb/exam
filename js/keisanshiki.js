function ttlValue() {
  chn = 0; // ラジオボタンとチェックボックスの総数
  slc = 9; // セレクトメニューの総数
  txt = 1; // テキスト領域の総数
  ttl = 0;
  // ラジオボタンorチェックボックス
  for(i=0; i<chn; i++) {
    if(document.nForm.elements[i].checked) {
      ttl += eval(document.nForm.elements[i].value);
    }
  }
  // セレクトメニュー
  for(i=chn; i<chn+slc; i++) {
    if(document.nForm.elements[i].value != "") {
      ttl += eval(document.nForm.elements[i].value);
    }
  }
  // テキスト領域の総数
  for(i=chn+slc; i<txt+chn+slc; i++) {
    if(document.nForm.elements[i].value != "") {
      ttl += eval(document.nForm.elements[i].value);
    }
  }
  document.nForm.result.value = ttl;
}

// 数値のみを入力可能にする
function numOnly() {
  m = String.fromCharCode(event.keyCode);
  if("0123456789\b".indexOf(m, 0) < 0) return false;
  return true;
}