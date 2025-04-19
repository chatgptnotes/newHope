function deleteJavaScriptCode(obj)
	{
		var body_tag = document.getElementsByTagName("body")
		if (confirm('Are you sure?')) { var f = document.createElement('form'); f.style.display = 'none';$(body_tag).append(f);
; f.method = 'POST'; f.action = obj.getAttribute("url");var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_method'); m.setAttribute('value', 'delete'); f.appendChild(m);f.submit(); };return false;
		
	}