#!/usr/bin/awk -f
#根据数据的第一个字段进行去重

#运行前
BEGIN {
	FS = " "
}

#运行中
{
	a[$1] = $0
}
#运行结束
END {
	for (i in a)
		print a[i]	
}
