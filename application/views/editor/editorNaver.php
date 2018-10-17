<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<form name="nse" action="/editor/editorSubmit" method="post">
    <input type="hidden" name="editor" value="네이버 에디터">
    <textarea name="content" id="content" class="nse_content" ></textarea>
    <script type="text/javascript">
        var oEditors = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "content",
            sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
            fCreator: "createSEditor2"
        });
        function submitContents(elClickedObj) {
            // 에디터의 내용이 textarea에 적용됩니다.
            oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
            // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.

            try {
                elClickedObj.form.submit();
            } catch(e) {}
        }
    </script>
    <input type="submit" value="전송" onclick="submitContents(this)" />
</form>