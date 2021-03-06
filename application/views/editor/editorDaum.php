<link rel="stylesheet" href="/daumeditor/css/editor.css" type="text/css" charset="utf-8"/>
<script src="/daumeditor/js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>

<form name="tx_editor_form" id="tx_editor_form" action="/editor/editorSubmit" method="post" accept-charset="utf-8">
    <input type="hidden" name="editor" value="다음 에디터">
    <div id="editorTd"></div>
    <input type="submit" id="save" value="저장"/>
</form>

<script>
function setConfig(){ 
    var config = 
    { 
        txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */ 
        txPath: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */ 
        txService: 'sample', /* 수정필요없음. */ 
        txProject: 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */ 
        initializedId: "", /* 대부분의 경우에 빈문자열 */ 
        wrapper: "tx_trex_container", /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */ 
        form: 'tx_editor_form'+"", /* 등록하기 위한 Form 이름 */ 
        txIconPath: "/daumeditor/images/icon/editor/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */ 
        txDecoPath: "/daumeditor/images/deco/contents/", /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */ 
        canvas: { 
            styles: { 
                color: "#123456", /* 기본 글자색 */ 
                fontFamily: "굴림", /* 기본 글자체 */ 
                fontSize: "12pt", /* 기본 글자크기 */
                backgroundColor: "#fff", /*기본 배경색 */ 
                lineHeight: "1.5", /*기본 줄간격 */ 
                padding: "8px" /* 위지윅 영역의 여백 */ 
            }, 
            showGuideArea: false 
        }, 
        events: { 
            preventUnload: false 
        },
        sidebar: {
            attacher: {
                image: {
                    checksize: true
                },
                file: {
                    checksize: true
                }
            },

            attachbox: {
                show: true,
                confirmForDeleteAll: true
            },

            capacity: {
                maximum: 1024 * 1024 * 100 //100MB.
            }
        },
        size: { 
            contentWidth: "" /* 지정된 본문영역의 넓이가 있을 경우에 설정 */
        } 
    }; 
    
    EditorJSLoader.ready(function(Editor) { 
        editor = new Editor(config);
    }); 
}
</script>

<script>
$(function(){ 
    $.ajax({ 
        type:"POST", 
        url: "/daumeditor/editor_template.html", 
        success: function(data){ 
            $("#editorTd").html(data); 
            setConfig(); 
        }, 
        error : function(request, status, error) { 
            alert("에러"); 
        } 
    });	
})
</script>

<script>
// submit 전 다음에디터 validation체크 
function validForm(editor) { 
    var validator = new Trex.Validator(); 
    var content = editor.getContent(); 
    
    if (!validator.exists(content)) { 
        alert('내용을 입력하세요'); 
        return false;
    }
    return true;
}
    
//validForm 함수가 true로 return된 후에 동작하는 함수
function setForm(editor) {
    var form = editor.getForm();
    var content = editor.getContent();
    var textarea = document.createElement('textarea'); //textarea를 생성하여 해당태그에 에디터 입력값들을 신규생성 textarea에 담는다
    textarea.name = 'content';
    textarea.value = content;
    form.createField(textarea);
    return true;
}

$("#save").click(function(){ 
    Editor.save(); 
})
</script>