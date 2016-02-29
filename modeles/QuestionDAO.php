<?php

/**
 * Classe pour l'accès à la table Question
 */
class QuestionDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM question WHERE id_question = :id_question');
		$req->execute(array(
			'id_question' => $id['id_question']
		));
		$res = $req->fetch();
		return new Question($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM question');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Question($ligne);
		}
		return $res;
	}

	public function save($question){
		if($question->id_question == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($question as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO question(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$question->id_question = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_question = $question->id_question;
			unset($question->id_question);
			$newValeurs = '';
			foreach($question as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE question SET $newValeurs WHERE id_question = '$id_question'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($question){
		return $this->pdo->exec("DELETE FROM question WHERE id_question = '$question->id_question'");
	}

}