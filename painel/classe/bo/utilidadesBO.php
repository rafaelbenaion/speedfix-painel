<?php 
class utilidadesBO {
	public static function executaSQL($sql,$loop=1){
		$db = new DBMySQL();
		$db->do_query($sql);
		$db->close();
		$c=0;
		if($loop == 1){
			while($row=$db->getRow()){
				$vetProduto[$c] = $row;
				$c++;
			}
			return $vetProduto;
		} else {
			return TRUE;
		}
	}
	
	public static function dateBR2MySQL($data, $mode = 'mysql') {
		
		if($mode == 'mysql') {
			
			$data = implode("-",array_reverse(explode("/",$data)));
			
					
		} else if($mode == 'br') {
			
			$data = implode("/",array_reverse(explode("-",$data)));			
			
		} else {
			
			$data = false;
			
		}
		
		return $data;
		
	}
	public static function horaFormata($hora){
		$hora = substr($hora,0,-3);
		return $hora;
	}
	public static function valorFin2Num($valor){
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.',$valor);
		return $valor;
	}
    public static function encode($str){
		for($i=0;$i<2;$i++)  {
			$str=strrev(base64_encode($str));
		}
		return $str;
    }
    public static function decode($str){
		for($i=0; $i<2;$i++){
			$str=base64_decode(strrev($str));
		}
		return $str;
    }
	public static function anti_injection($dados){
		$seg = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$dados);
		$seg = trim($seg);
		$seg = strip_tags($seg);
		$seg = addslashes($seg);
		return $seg;
	}
	
	public static function getIp(){	
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){	
			$ip = $_SERVER['HTTP_CLIENT_IP'];	
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){	
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];	
		}
		else{	
			$ip = $_SERVER['REMOTE_ADDR'];	
		}	
		return $ip;	
	}
	
	/**
	 * Formata um numero em notacao de moeda, assim como a funcao money_format do PHP
	 * @author Rubens Takiguti Ribeiro
	 * @see http://php.net/manual/en/function.money-format.php
	 * @param string $formato Formato aceito por money_format
	 * @param float $valor Valor monetario
	 * @return string Valor formatado
	 */
	public static function my_money_format($formato, $valor) {
	
		// Se a funcao money_format esta disponivel: usa-la
		if (function_exists('money_format')) {
			return money_format($formato, $valor);
		}
	
		// Se nenhuma localidade foi definida, formatar com number_format
		if (setlocale(LC_MONETARY, 0) == 'C') {
			return number_format($valor, 2);
		}
	
		// Obter dados da localidade
		$locale = localeconv();
	
		// Extraindo opcoes do formato
		$regex = '/^'.             // Inicio da Expressao
				'%'.              // Caractere %
				'(?:'.            // Inicio das Flags opcionais
				'\=([\w\040])'.   // Flag =f
				'|'.
				'([\^])'.         // Flag ^
				'|'.
				'(\+|\()'.        // Flag + ou (
				'|'.
				'(!)'.            // Flag !
				'|'.
				'(-)'.            // Flag -
				')*'.             // Fim das flags opcionais
				'(?:([\d]+)?)'.   // W  Largura de campos
				'(?:#([\d]+))?'.  // #n Precisao esquerda
				'(?:\.([\d]+))?'. // .p Precisao direita
				'([in%])'.        // Caractere de conversao
				'$/';             // Fim da Expressao
	
		if (!preg_match($regex, $formato, $matches)) {
			trigger_error('Formato invalido: '.$formato, E_USER_WARNING);
			return $valor;
		}
	
		// Recolhendo opcoes do formato
		$opcoes = array(
				'preenchimento'   => ($matches[1] !== '') ? $matches[1] : ' ',
				'nao_agrupar'     => ($matches[2] == '^'),
				'usar_sinal'      => ($matches[3] == '+'),
				'usar_parenteses' => ($matches[3] == '('),
				'ignorar_simbolo' => ($matches[4] == '!'),
				'alinhamento_esq' => ($matches[5] == '-'),
				'largura_campo'   => ($matches[6] !== '') ? (int)$matches[6] : 0,
				'precisao_esq'    => ($matches[7] !== '') ? (int)$matches[7] : false,
				'precisao_dir'    => ($matches[8] !== '') ? (int)$matches[8] : $locale['int_frac_digits'],
				'conversao'       => $matches[9]
		);
	
		// Sobrescrever $locale
		if ($opcoes['usar_sinal'] && $locale['n_sign_posn'] == 0) {
			$locale['n_sign_posn'] = 1;
		} elseif ($opcoes['usar_parenteses']) {
			$locale['n_sign_posn'] = 0;
		}
		if ($opcoes['precisao_dir']) {
			$locale['frac_digits'] = $opcoes['precisao_dir'];
		}
		if ($opcoes['nao_agrupar']) {
			$locale['mon_thousands_sep'] = '';
		}
	
		// Processar formatacao
		$tipo_sinal = $valor >= 0 ? 'p' : 'n';
		if ($opcoes['ignorar_simbolo']) {
			$simbolo = '';
		} else {
			$simbolo = $opcoes['conversao'] == 'n' ? $locale['currency_symbol']
			: $locale['int_curr_symbol'];
		}
		$numero = number_format(abs($valor), $locale['frac_digits'], $locale['mon_decimal_point'], $locale['mon_thousands_sep']);
	
		/*
		 //TODO: dar suporte a todas as flags
		list($inteiro, $fracao) = explode($locale['mon_decimal_point'], $numero);
		$tam_inteiro = strlen($inteiro);
		if ($opcoes['precisao_esq'] && $tam_inteiro < $opcoes['precisao_esq']) {
		$alinhamento = $opcoes['alinhamento_esq'] ? STR_PAD_RIGHT : STR_PAD_LEFT;
		$numero = str_pad($inteiro, $opcoes['precisao_esq'] - $tam_inteiro, $opcoes['preenchimento'], $alinhamento).
		$locale['mon_decimal_point'].
		$fracao;
		}
		*/
	
		$sinal = $valor >= 0 ? $locale['positive_sign'] : $locale['negative_sign'];
		$simbolo_antes = $locale[$tipo_sinal.'_cs_precedes'];
	
		// Espaco entre o simbolo e o numero
		$espaco1 = $locale[$tipo_sinal.'_sep_by_space'] == 1 ? ' ' : '';
	
		// Espaco entre o simbolo e o sinal
		$espaco2 = $locale[$tipo_sinal.'_sep_by_space'] == 2 ? ' ' : '';
	
		$formatado = '';
		switch ($locale[$tipo_sinal.'_sign_posn']) {
			case 0:
				if ($simbolo_antes) {
					$formatado = '('.$simbolo.$espaco1.$numero.')';
				} else {
					$formatado = '('.$numero.$espaco1.$simbolo.')';
				}
				break;
			case 1:
				if ($simbolo_antes) {
					$formatado = $sinal.$espaco2.$simbolo.$espaco1.$numero;
				} else {
					$formatado = $sinal.$numero.$espaco1.$simbolo;
				}
				break;
			case 2:
				if ($simbolo_antes) {
					$formatado = $simbolo.$espaco1.$numero.$sinal;
				} else {
					$formatado = $numero.$espaco1.$simbolo.$espaco2.$sinal;
				}
				break;
			case 3:
				if ($simbolo_antes) {
					$formatado = $sinal.$espaco2.$simbolo.$espaco1.$numero;
				} else {
					$formatado = $numero.$espaco1.$sinal.$espaco2.$simbolo;
				}
				break;
			case 4:
				if ($simbolo_antes) {
					$formatado = $simbolo.$espaco2.$sinal.$espaco1.$numero;
				} else {
					$formatado = $numero.$espaco1.$simbolo.$espaco2.$sinal;
				}
				break;
		}
	
		// Se a string nao tem o tamanho minimo
		if ($opcoes['largura_campo'] > 0 && strlen($formatado) < $opcoes['largura_campo']) {
			$alinhamento = $opcoes['alinhamento_esq'] ? STR_PAD_RIGHT : STR_PAD_LEFT;
			$formatado = str_pad($formatado, $opcoes['largura_campo'], $opcoes['preenchimento'], $alinhamento);
		}
	
		return $formatado;
	}
	
	public static function trataTxt($var) {
	
		$var = strtolower($var);
	
		$var = ereg_replace("[áàâãª]","a",$var);
		$var = ereg_replace("[éèê]","e",$var);
		$var = ereg_replace("[óòôõº]","o",$var);
		$var = ereg_replace("[úùû]","u",$var);
		$var = str_replace("ç","c",$var);
	
		return $var;
	}

	public function cortaTexto($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
					// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
						unset($open_tags[$pos]);
						}
					// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}
	
}
?>