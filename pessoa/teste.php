<?php
echo '
<div class="form-group">
    <label class="col-xs-3 control-label">Language</label>
    <div class="col-xs-7">
        <div class="dropdown">
          <button id="mydef" class="btn dropdown-toggle" type="button" data-toggle="dropdown" onclick="doOn(this);">
            <div class="col-xs-10">
                <input type="text" id="search" placeholder="search" onkeyup="doOn(this);"></input>
            </div>
            <span class="glyphicon glyphicon-search"></span>
         </button>
      <ul id="def" class="dropdown-menu" style="display:none;" >
            <li><a id="HTML" onclick="mydef(this);" >HTML</a></li>
            <li><a id="CSS" onclick="mydef(this);" >CSS</a></li>
            <li><a id="JavaScript" onclick="mydef(this);" >JavaScript</a></li>
      </ul>
      <ul id="def1" class="dropdown-menu" style="display:none"></ul>
    </div>
</div>';
?>

<script>
function doOn(obj)
     {

        if(obj.id=="mydef")
        {
            document.getElementById("def1").style.display="none";
            document.getElementById("def").style.display="block";
        }
        if(obj.id=="search")
        {
            document.getElementById("def").style.display="none";

            document.getElementById("def1").innerHTML='<li><a id="Java" onclick="mydef(this);" >java</a></li><li><a id="oracle" onclick="mydef(this);" >Oracle</a></li>';

            document.getElementById("def1").style.display="block";
        }

    }
    function mydef(obj)
    {
        document.getElementById("search").value=obj.innerHTML;
        document.getElementById("def1").style.display="none";
        document.getElementById("def").style.display="none";
    }
</script>
