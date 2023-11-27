<?php
class Message{
    public $username;
    public $message;
    private $date;

    public function __construct(string $username, string $message, ?DateTime $date = null){
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new DateTime();
    }

    public function isValid(): bool{
        return empty($this->getErrors());
    }

    public function getErrors():array{
        $errors = [];
        if(strlen($this->username) < 3){
            $errors['username'] = "Votre pseudo est trop court";
        }
        if(strlen($this->message) < 20){
            $errors['message'] = "Votre message est trop court";
        }
        return $errors;
    }

    public function toHTML()
    {
        $username = htmlentities($this->username);
        $date = $this->date->format('d-m-Y a H:i');
        $message = htmlentities($this->message);
        
        return "<p>
            <strong>{$username}</strong> le <em>{$date}</em>
            <br>{$message}
        </p>";
    }

    public function toJSON(){
        return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()
        ]);
    }
}