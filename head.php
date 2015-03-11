<script>

var initList = [];

function addInitFunc(func)
{
	initList[initList.length] = func;
}

function init()
{
	for (var i in initList)
		initList[i]();
}

</script>
