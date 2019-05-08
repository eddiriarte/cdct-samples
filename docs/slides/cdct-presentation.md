<!-- class="abstract-title" -->
## Agenda

- What is `Consumer Driven Contract Testing`?
- Why should I use this methodology?
- What is `PACT` and why should I use it?
- Boundaries & Pit-Falls


## What is <span class="handy">Consumer Driven Contract Testing</span>?


### Split the big name into terms...


<img class="plain" src="./media/consumer.svg">

Application consuming an API/Service

<footer class="credits">
    <div>Icons made by <a href="https://www.freepik.com/?__hstc=57440181.81fa847e192273dea5b488970c65c1dc.1556711369388.1556711369388.1556711369388.1&__hssc=57440181.5.1556711369389&__hsfp=106385111" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 		    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 		    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
</footer>


<img class="plain" src="./media/consumer-driven.svg">

Service/API development gets driven by consumer, who defines expectation constraints for requests

<footer class="credits">
    <div>Icons made by <a href="https://www.freepik.com/?__hstc=57440181.81fa847e192273dea5b488970c65c1dc.1556711369388.1556711369388.1556711369388.1&__hssc=57440181.5.1556711369389&__hsfp=106385111" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 		    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 		    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
</footer>


<img class="plain" src="./media/contract.svg">

Agreed definition of constraints for the Service/API

<footer class="credits">
    <div>Icons made by <a href="https://www.freepik.com/?__hstc=57440181.81fa847e192273dea5b488970c65c1dc.1556711369388.1556711369388.1556711369388.1&__hssc=57440181.5.1556711369389&__hsfp=106385111" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 		    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 		    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
</footer>


<img class="plain" src="./media/contract-testing.svg">

Verified communication by given contract

<footer class="credits">
    <div>Icons made by <a href="https://www.freepik.com/?__hstc=57440181.81fa847e192273dea5b488970c65c1dc.1556711369388.1556711369388.1556711369388.1&__hssc=57440181.5.1556711369389&__hsfp=106385111" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 		    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 		    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
</footer>


## In other words

`Consumer-Driven Contract Testing` is...


<!-- .slide: id="definition" -->
A strategy  to test communication between services, constrained to a given contract. Contracts must be therefore explicitly defined by the service-consumer and verified by the service-provider.


## What is it good for?


<img class="plain" src="./media/api-development-start.svg" width="85%" alt="API Development - Start">


<img class="plain" src="./media/api-development-provider-update.svg" width="85%" alt="API Development - Provider update">


<img class="plain" src="./media/api-development-postels-law.svg" width="85%" alt="API Development - Postel's Law">


<img class="plain" src="./media/api-development-versionized.svg" width="85%" alt="API Development - Versionized API">

Note:
- Lack of knowledge about consumer requirements
- Lack of knowledge of consumer status
- End-Point Jungles
- Documentation of historical changes


<!-- .slide: data-background-image="https://media.giphy.com./media/3oFzmhSdxPiyRyR5vi/giphy-downsized.gif" data-background-size="cover" -->
## Can I Use?


<img class="plain" src="./media/can-i-use.png" width="80%" alt="Can I User - Tools">


## What is <span class="handy">PACT</span>?


<strong>Pact is a contract testing tool.</strong> Contract testing is a way to ensure that services (such as an API provider and a client) can communicate with each other. Without contract testing, the only way to know that services can communicate is by using expensive and brittle integration tests.

<footer class="credits">
    From: <a href="https://docs.pact.io/" title="Pact">pact.io</a> documentation.
</footer>


<!-- .slide: data-background-image="./media/demo-architecture.png" data-background-size="cover" -->
## DEMO

`git clone https://github.com/eddiriarte/cdct-samples.git` <small>* still working on it</small>


## Surprises & Pit-Falls of `PACT`

<div class="two-columns-container">
    <article class="column">
        - ![]open source<br>
        - growing community<br>
        - tech. agnostic<br>
        - highly extensible<br>
        - GitHooks
    </article>
    <article class="column">
        - hard intro<br>
        - still buggy ;)<br>
        - distributed teams required<br>
        - difficult setup<br>
    </article>
</div>


## Questions / Feedback


## thx


## Links and Sources

<div class="two-columns-container lefted">
    <article class="column">
        - [Testing Microservices, M. Fowler](https://martinfowler.com/articles/microservice-testing)<br>
        - [Postman Contract Tests](https://medium.com/better-practices/consumer-driven-contract-testing-using-postman-f3580dba5370)<br>
        - [Consumer Contracts, M. Fowler](https://www.martinfowler.com/articles/consumerDrivenContracts.html#Consumer-drivenContracts)<br>
    </article>
    <article class="column">
        - [Pact](https://docs.pact.io/)<br>
        - [Newman](https://github.com/postmanlabs/newman)<br>
        - [Dredd](https://dredd.org/en/latest/)<br>
        - [Blueprint](https://apiblueprint.org)<br>
    </article>
</div>
