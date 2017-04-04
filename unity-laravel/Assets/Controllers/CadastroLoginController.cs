using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CadastroLoginController : MonoBehaviour {
	public string _urlCadastro;

	public UsuarioController _usuarioCtl;

	public Response _response;

	private WWW _www;
	private WWWForm _form;

	// Use this for initialization
	void Start () {
		StartCoroutine (cadastro());
	}
	
	// Update is called once per frame
	void Update () {
		
	}

	public IEnumerator cadastro(){
		_form = new WWWForm ();
		_form.AddField ("name","admin");
		_form.AddField ("email","admin@admin.com");
		_form.AddField ("password","123456");

		_www = new WWW (_urlCadastro, _form);
		yield return _www;

		if(_www.error==null){
			_response = JsonUtility.FromJson<Response>(_www.text);
			if(_response.status){
				_usuarioCtl._usuario = _response.user;
			}else{
				foreach (var item in _response.errors) {
					print(item);
				}
			}
		}else{
			print(_www.error);
		}
	}
}
