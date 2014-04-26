/**
 * 
 * @authors tam
 * @date    2014-04-26 18:00:20
 * @version 1.00
 */

/**
 * @name: format
 * @description: 为字符串动态传值(以object的key值去替换对应的地方)
 * @param: string	//替换的字符串
 * @param: object   //object对象{'name':1}
 * @return: string
 * @author: ctam
 * @create: 2013-11-28 9:50:51
**/
function format(str,object) {
	for (var property in object) {
		str = str.replace(new RegExp('%' + property,"gm"), object[property]);
	}
	return str;
}
