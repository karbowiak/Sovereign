<?php

namespace Sovereign\Lib;


/**
 * Class Users
 * @package Sovereign\Lib
 */
/**
 * Class Users
 * @package Sovereign\Lib
 */
class Users
{
    /**
     * @var Db
     */
    protected $db;

    /**
     * Users constructor.
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param $userID
     * @param $name
     * @param $lastStatus
     * @param $game
     * @param $lastSeen
     * @param $lastSpoke
     * @param $lastWritten
     * @throws \Exception
     */
    public function set($userID, $name, $lastStatus, $game, $lastSeen, $lastSpoke, $lastWritten)
    {
        try {
            if (isset($lastStatus)) {
                $this->db->execute("INSERT INTO users (discordID, nickName, lastStatus) VALUES (:discordID, :nickName, :lastStatus) ON DUPLICATE KEY UPDATE lastStatus = :lastStatus", [":discordID" => $userID, ":nickName" => $name, ":lastStatus" => $lastStatus]);
            }

            if (isset($game)) {
                $this->db->execute("INSERT INTO users (discordID, nickName, game) VALUES (:discordID, :nickName, :game) ON DUPLICATE KEY UPDATE game = :game", [":discordID" => $userID, ":nickName" => $name, ":game" => $game]);
                $this->db->execute("INSERT IGNORE INTO games (game) VALUES (:game)", array(":game" => $game));
            }

            if (isset($lastSeen)) {
                $this->db->execute("INSERT INTO users (discordID, nickName, lastSeen) VALUES (:discordID, :nickName, :lastSeen) ON DUPLICATE KEY UPDATE lastSeen = :lastSeen", [":discordID" => $userID, ":nickName" => $name, ":lastSeen" => $lastSeen]);
            }

            if (isset($lastSpoke)) {
                $this->db->execute("INSERT INTO users (discordID, nickName, lastSpoke) VALUES (:discordID, :nickName, :lastSpoke) ON DUPLICATE KEY UPDATE lastSpoke = :lastSpoke", [":discordID" => $userID, ":nickName" => $name, ":lastSpoke" => $lastSpoke]);
            }

            if (isset($lastWritten)) {
                $this->db->execute("INSERT INTO users (discordID, nickName, lastWritten) VALUES (:discordID, :nickName, :lastWritten) ON DUPLICATE KEY UPDATE lastWritten = :lastWritten", [":discordID" => $userID, ":nickName" => $name, ":lastWritten" => $lastWritten]);
            }
        } catch (\Exception $e) {
            throw new \Exception("There was an error setting data for {$name}: {$e->getMessage()}");
        }
    }

    /**
     * @param $userID
     * @return array
     */
    public function get($userID)
    {
        return $this->db->queryRow("SELECT * FROM users WHERE userID = :userID", array(":userID" => $userID));
    }
}