<?php
Class Rover
{
    private $x;
    private $y;
    private $facingDegrees;
    private $facingString;
    private $forward;
	
	private $debug;
	
	function __construct($debug)
	{
		$this->debug = $debug;
	}
		
	
	function start($x,$y,$facingString,$instructions)
	{
		$this->x = $x;
		$this->y = $y;
		$this->facingString = $facingString;
		$this->facingDegrees = $this->translateStringDegrees($facingString);
		$this->updateForward();
				
		$this->move($instructions);
	}
	
	function forward()
	{
		
		
		if ($this->forward == "N")
			$this->y += 1;
		else if ($this->forward == "S")
			$this->y -= 1;
		else if ($this->forward == "E")
			$this->x += 1;
		else if ($this->forward == "W")
			$this->x -= 1;
	}

	function turn($instruction)
	{
		if ($instruction == 'L')
		{
			$this->facingDegrees -= 90;
		}
		else if ($instruction == 'R')
		{
			$this->facingDegrees += 90;
		}
		
		//fix 0-360 above
		if ($this->facingDegrees <= 0)
		{
			$this->facingDegrees += 360;
		}
		
		//fix 0-360
		if ($this->facingDegrees > 360)
		{
			$this->facingDegrees = 90;
		}
		
		//update sight
		$this->updateForward();
		
	}

	//function move
	function move($instructions)
	{
		if ($this->debug)
			echo "Starting... Facing to ".$this->forward." at (".$this->x.",".$this->y.")(".$this->facingDegrees."o)\n";
		
		for ($i=0; $i<strlen($instructions); $i++)
		{			
			if ($this->debug)
				echo "cmd ".$i." - ";
			
			if ($instructions[$i] != "M")
			{
				$this->turn($instructions[$i]);
				if ($this->debug)
					echo "Turn to ".$instructions[$i]." = (".$this->forward.") (".$this->facingDegrees."o)";
			}
			else
			{
				$this->forward();
				if ($this->debug)
					echo "Move to ".$this->forward." = (".$this->x.",".$this->y.")";
			}
			
			if ($this->debug)
				echo "\n";
		}
		
		//break line in the end for output
		echo $this->x." ".$this->y." ".$this->forward;
		echo "\n";
	}
    
    function translateStringDegrees($d)
	{
		if ($d == "N")
			return 0;
		else if ($d == "E")
			return 90;
		else if ($d == "S")
			return 180;
		else if ($d == "W")
			return 270;
		else
			return 360;
	}
	
	function updateForward()
	{
		if ($this->facingDegrees == 360)
			$this->forward = "N";
		else if ($this->facingDegrees == 90)
			$this->forward = "E";
		else if ($this->facingDegrees == 180)
			$this->forward = "S";
		else if ($this->facingDegrees == 270)
			$this->forward = "W";
		else
			$this->forward = "N";
	}
}



$debug = false;

$rover = new Rover($debug);

$rover->start(1,2,"N","LMLMLMLMM");

$rover->start(3,3,"E","MMRMMRMRRM");



