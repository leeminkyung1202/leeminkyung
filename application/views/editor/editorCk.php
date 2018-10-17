<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    //<![CDATA[
    function LoadPage() {
        CKEDITOR.replace('content');
    }

    function FormSubmit(f) {
        CKEDITOR.instances.content.updateElement();
        if(f.content.value == "") {
            alert("내용을 입력해 주세요.");
            return false;
        }
        f.form.submit();
    }
    //]]>
</script>

<body onload="LoadPage();">
<form id="EditorForm" name="EditorForm" action="/editor/editorSubmit" method="post" onsubmit="return FormSubmit(this);">
    <input type="hidden" name="editor" value="ck 에디터">
    <textarea id="content" name="content"></textarea>
    <input type="submit" value="전송">
</form>
</body>
